<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

use JMS\Serializer\Annotation as JMS;

class SpecialityModel
{
    public function __construct(
        private string $speciality,
        private string $level,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $attestationDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $validTo,

        private bool $specialityOfficio,
    ) {}
}
