<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class SpecialityModel
{
    public function __construct(
        private string $speciality,
        private bool $specialityOfficio,
        private string $level,
        private string $qualificationType,
        private string $attestationName,
        private string $attestationDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $validTo,
    ) {}
}
