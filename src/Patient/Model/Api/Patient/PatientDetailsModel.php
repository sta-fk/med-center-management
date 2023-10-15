<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Patient;

use App\Base\Model\Api\ContactsModel;
use JMS\Serializer\Annotation as JMS;

class PatientDetailsModel
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $secondName,
        private string $birthDate,
        private string $birthCountry,
        private string $birthCity,
        private string $gender,
        private string $email,

        /**
         * @var ContactsModel[]
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array  $phones,

        /**
         * @var PatientAddressModel[]
         * @JMS\Type("array<App\Patient\Model\Api\Patient\PatientAddressModel>")
         */
        private array  $addresses,
    ) {}
}
