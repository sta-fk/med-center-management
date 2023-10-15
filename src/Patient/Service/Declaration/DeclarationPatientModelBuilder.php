<?php declare(strict_types=1);

namespace App\Patient\Service\Declaration;

use App\Base\Service\ContactsModelsProvider;
use App\Patient\Exception\InvalidDeclarationException;
use App\Patient\Model\Api\Declaration\DeclarationPatientBirthCertificateModel;
use App\Patient\Model\Api\Declaration\DeclarationPatientModel;
use App\PatientUser\Model\Api\Request\Documents\PatientDocumentModel;
use App\PatientUser\Model\Api\Request\Documents\PatientIdCardModel;
use App\PatientUser\Model\Api\Request\Documents\PatientPassportModel;

class DeclarationPatientModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
    ) {}

    public function getDeclarationPatientModel(array $patientDetails): DeclarationPatientModel
    {
        $confidentDetails = $patientDetails['confidant_person'][0] ?? throw new InvalidDeclarationException();
        $documents = $confidentDetails['documents_person'][0] ?? throw new InvalidDeclarationException();
        $birthCertificate = $confidentDetails['documents_relationship'][0] ?? throw new InvalidDeclarationException();

        return new DeclarationPatientModel(
            $patientDetails['id'],
            $confidentDetails['first_name'],
            $confidentDetails['last_name'],
            $confidentDetails['second_name'],
            new \DateTimeImmutable($confidentDetails['birth_date']),
            $confidentDetails['birth_country'],
            $confidentDetails['birth_settlement'],
            $this->formatGender($confidentDetails['gender']),
            $this->contactsModelsProvider->getEhealthContactsModels($confidentDetails['phones']),
            $confidentDetails['email'],
            $this->buildDocumentsModel($documents, $confidentDetails['tax_id']),
            $this->buildBirthCertificateModel($birthCertificate),
        );
    }

    private function formatGender(string $gender): bool
    {
        return match($gender) {
            'MALE' => false,
            'FEMALE' => true,
        };
    }

    public function buildDocumentsModel(array $patientDocuments, string $inn): PatientDocumentModel
    {
        return match (true) {
            (key_exists('expiration_date', $patientDocuments)
                && $patientDocuments['type'] === 'PASSPORT') => new PatientPassportModel(
                substr($patientDocuments['number'], 0, -6),
                substr($patientDocuments['number'], -6),
                new \DateTimeImmutable($patientDocuments['issued_at']),
                $patientDocuments['issued_by'],
                $inn,
            ),
            key_exists('expiration_date', $patientDocuments) => new PatientIdCardModel(
                $patientDocuments['number'],
                new \DateTimeImmutable($patientDocuments['expiration_date']),
                new \DateTimeImmutable($patientDocuments['issued_at']),
                $patientDocuments['issued_by'],
                $inn,
            ),
        };
    }

    public function buildBirthCertificateModel(array $birthCertificate): DeclarationPatientBirthCertificateModel
    {
        return new DeclarationPatientBirthCertificateModel(
            $birthCertificate['number'],
            new \DateTimeImmutable($birthCertificate['issued_at']),
            $birthCertificate['issued_by'],
        );
    }
}
