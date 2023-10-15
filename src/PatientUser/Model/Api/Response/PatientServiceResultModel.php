<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Response;

use JMS\Serializer\Annotation as JMS;

class PatientServiceResultModel
{
    public function __construct(
        private string $name,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $date,

        private string $url,
    ) {}
}
