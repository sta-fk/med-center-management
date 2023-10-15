<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Declaration;

use JMS\Serializer\Annotation as JMS;

class DeclarationPatientBirthCertificateModel
{
    public function __construct(
        private string $number,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $issueDate,

        private string $issuePlace,
    ) {}
}
