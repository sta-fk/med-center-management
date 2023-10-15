<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Declaration;

use App\Base\Model\Api\ContactsModel;
use App\PatientUser\Model\Api\Request\Documents\PatientDocumentModel;
use JMS\Serializer\Annotation as JMS;

class DeclarationPatientModel
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $patronymic,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $birthDate,

        private string $birthCountry,
        private string $birthCity,

        private bool $gender,

        /**
         * @var ContactsModel[]
         *
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        private string $email,
        private PatientDocumentModel $document,
        private DeclarationPatientBirthCertificateModel $birthCertificate,
    ) {}
}
