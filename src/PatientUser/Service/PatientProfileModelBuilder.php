<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\Base\Service\ContactsModelsProvider;
use App\Base\Service\FullAddressModelsProvider;
use App\PatientUser\Entity\PatientAdditionalInfo;
use App\PatientUser\Entity\PatientProfile;
use App\PatientUser\Model\Api\Request\Documents\PatientDocumentModel;
use App\PatientUser\Model\Api\Request\Documents\PatientIdCardModel;
use App\PatientUser\Model\Api\Request\Documents\PatientPassportModel;
use App\PatientUser\Model\Api\Response\PatientProfileModel;

class PatientProfileModelBuilder
{
    public function __construct(
        private ContactsModelsProvider    $contactsModelsProvider,
        private FullAddressModelsProvider $addressModelsProvider,
    ) {}

    public function buildPatientProfileModel(PatientProfile $profile): PatientProfileModel
    {
        $additionalInfo = $profile->getAdditionalInfo();

        $contacts = $this->contactsModelsProvider->getContactsModels($profile->getContacts()->getValues());
        $addresses = $this->addressModelsProvider->getAddressesModels($profile->getAddresses()->getValues());

        return new PatientProfileModel(
            $profile->getUser()->getId(),
            $additionalInfo->getGender(),
            $profile->getFirstName(),
            $profile->getLastName(),
            $profile->getPatronymic(),
            $additionalInfo->getBirthDate(),
            $additionalInfo->getBirthCountry(),
            $additionalInfo->getBirthCity(),
            $contacts->getContacts()->getValues(),
            $addresses->getAddresses()->getValues(),
            $this->buildDocumentsModel($additionalInfo),
        );
    }

    public function buildDocumentsModel(PatientAdditionalInfo $documents): PatientDocumentModel
    {
        return match ($documents->getDocumentType()) {
            1 => new PatientPassportModel(
                $documents->getPassportSeries(),
                $documents->getPassportNumber(),
                $documents->getPassportDate(),
                $documents->getPassportGive(),
                $documents->getInn(),
            ),
            2 => new PatientIdCardModel(
                $documents->getIdCardNumber(),
                $documents->getIdCardExpiredAt(),
                $documents->getIdCardIssuedAt(),
                $documents->getIdCardIssuedBy(),
                $documents->getInn(),
            ),
        };
    }
}
