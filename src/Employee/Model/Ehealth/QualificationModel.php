<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class QualificationModel
{
    public function __construct(
        private string $type,
        private string $institutionName,
        private string $speciality,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $issuedDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $validTo,

        private string $additionalInfo,
    ) {}
}
