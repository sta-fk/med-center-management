<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\Base\Model\Api\ContactsModel;
use App\Base\Model\Api\FullAddressModel;
use App\Patient\Entity\PatientEhealthInfo;
use App\Patient\Service\DeclarationProvider;
use App\Patient\Service\PatientSearchService;
use App\PatientUser\Entity\PatientAdditionalInfo;
use App\PatientUser\Entity\PatientAddress;
use App\PatientUser\Entity\PatientContacts;
use App\PatientUser\Entity\PatientProfile;
use App\PatientUser\Model\Api\Request\Documents\PatientIdCardModel;
use App\PatientUser\Model\Api\Request\Documents\PatientPassportModel;
use App\PatientUser\Model\Api\Request\PatientProfileModel;
use App\PatientUser\Repository\PatientUserRepository;
use libphonenumber\PhoneNumber;
use Psr\Log\LoggerInterface;

class PatientProfileService
{
    public function __construct(
        private PatientUserRepository $userRepository,
        private PatientSearchService $patientSearchService,
        private DeclarationProvider $declarationProvider,
        private LoggerInterface $patientUserApiLogger,
    ) {}

    public function createProfile(PatientProfileModel $profileModel, int $userId): PatientProfile
    {
        $profile = new PatientProfile();

        $this->createContacts($profile, $profileModel->getPhones());
        $this->createAddresses($profile, $profileModel->getAddresses());

        try {
            $profile
                ->setFirstName($profileModel->getFirstName())
                ->setLastName($profileModel->getLastName())
                ->setPatronymic($profileModel->getPatronymic())
                ->setAdditionalInfo($this->createAdditionalInfo($profileModel))
                ->setUser($this->userRepository->findOneBy(['id' => $userId]));
        } catch (\Throwable $e) {
            //todo: throw exception

            $this->patientUserApiLogger->warning(__METHOD__, ['message' => $e->getMessage()]);
        }

        try {
            $this->searchPatientInEhealth($profile, $profileModel);
        } catch (\Throwable) {
            $this->patientUserApiLogger->warning(__METHOD__, ['message' => 'Patient was not found in Ehealth']);
        }

        return $profile;
    }

    /**
     * @param ContactsModel[] $contacts
     */
    private function createContacts(PatientProfile $profile, array $contacts): void
    {
        array_map(
            function (ContactsModel $contactsModel) use ($profile) {
                $contact = new PatientContacts();

                $phone = new PhoneNumber();
                $phone
                    ->setCountryCode(380)
                    ->setNationalNumber(mb_substr($contactsModel->getPhoneNumber(), -9));

                $contact
                    ->setType($contactsModel->getType())
                    ->setPhoneNumber($phone);

                $profile->addContact($contact);

            }, $contacts
        );
    }

    private function createAddresses(PatientProfile $profile, array $addresses): void
    {
        array_map(
            function (FullAddressModel $addressModel) use ($profile) {
                $address = new PatientAddress();

                $address
                    ->setType($addressModel->getType())
                    ->setCountry($addressModel->getCountry())
                    ->setArea($addressModel->getArea())
                    ->setRegion($addressModel->getRegion())
                    ->setSettlementType($addressModel->getSettlementType())
                    ->setSettlement($addressModel->getSettlement())
                    ->setDistrict($addressModel->getDistrict())
                    ->setStreet($addressModel->getStreet())
                    ->setHouse($addressModel->getHouse())
                    ->setApartment($addressModel->getApartment())
                    ->setZip($addressModel->getZip())
                    ->setComment($addressModel->getComment());

                $profile->addAddress($address);

            }, $addresses
        );
    }

    private function createAdditionalInfo(PatientProfileModel $profileModel): PatientAdditionalInfo
    {
        $additionalInfo = new PatientAdditionalInfo();
        $additionalInfo
            ->setGender($profileModel->getDocuments()->getGender())
            ->setInn($profileModel->getDocuments()->getInn())
            ->setDocumentType($profileModel->getDocuments()->getType())
            ->setBirthDate($profileModel->getBirthDate())
            ->setBirthCountry($profileModel->getBirthCountry())
            ->setBirthCity($profileModel->getBirthCity());

        match (true) {
            $profileModel->getDocuments() instanceof PatientPassportModel =>
            $additionalInfo
                ->setPassportSeries($profileModel->getDocuments()->getRange())
                ->setPassportNumber($profileModel->getDocuments()->getNumber())
                ->setPassportDate($profileModel->getDocuments()->getIssueDate())
                ->setPassportGive($profileModel->getDocuments()->getIssuePlace()),
            $profileModel->getDocuments() instanceof PatientIdCardModel =>
            $additionalInfo
                ->setIdCardNumber($profileModel->getDocuments()->getNumber())
                ->setIdCardIssuedAt($profileModel->getDocuments()->getIssueDate())
                ->setIdCardIssuedBy($profileModel->getDocuments()->getIssuePlace())
                ->setIdCardExpiredAt($profileModel->getDocuments()->getExpireDate()),
        };

        return $additionalInfo;
    }

    private function searchPatientInEhealth(PatientProfile $profile, PatientProfileModel $profileModel): void
    {
        $patientId = $this->patientSearchService->searchPatientInEhealth($profileModel);
        $declarationId = $this->declarationProvider->getDeclarationIdByPatientId($patientId);

        if ($patientId && $declarationId) {
            $ehealthInfo = new PatientEhealthInfo();
            $ehealthInfo
                ->setPatientId($patientId)
                ->setDeclarationId($declarationId);

            $profile->setPatientEhealthInfo($ehealthInfo);
        }
    }
}
