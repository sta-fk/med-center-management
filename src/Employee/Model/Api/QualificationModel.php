<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

use JMS\Serializer\Annotation as JMS;

class QualificationModel
{
    public function __construct(
        private string $speciality,
        private string $institutionName,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $validTo,
    ) {}
}
