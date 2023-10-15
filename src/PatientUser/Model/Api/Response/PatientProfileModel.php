<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Response;

use App\Base\Model\Api\ContactsModel;
use App\Base\Model\Api\FullAddressModel;
use App\PatientUser\Model\Api\Request\Documents\PatientDocumentModel;
use JMS\Serializer\Annotation as JMS;

class PatientProfileModel
{
    public function __construct(
        private int $id,
        private bool $gender,
        private string $firstName,
        private string $lastName,
        private string $patronymic,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $birthDate,

        private string $birthCountry,
        private string $birthCity,

        /**
         * @var ContactsModel[]
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        /**
         * @var FullAddressModel[]
         * @JMS\Type("array<App\Base\Model\Api\FullAddressModel>")
         */
        private array $addresses,

        /**
         * @JMS\Exclude()
         */
        private PatientDocumentModel $document,
    ) {}
}
