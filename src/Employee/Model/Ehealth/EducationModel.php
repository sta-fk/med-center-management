<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class EducationModel
{
    public function __construct(
        private string $country,
        private string $city,
        private string $institutionName,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $issuedDate,

        private string $degree,
        private string $speciality,
    ) {}
}
