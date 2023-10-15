<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class ScienceDegreeModel
{
    public function __construct(
        private string $country,
        private string $city,
        private string $degree,
        private string $institutionName,
        private string $speciality,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $issuedDate,
    ) {}
}
