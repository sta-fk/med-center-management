<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Declaration;

use JMS\Serializer\Annotation as JMS;

class DeclarationModel
{
    public function __construct(
        private string $id,
        private string $declarationNumber,
        private string $status,
        private string $scope,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $startDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $endDate,

        private DeclarationPatientModel $patient,
        private DeclarationEmployeeModel $employee,
        private DeclarationDivisionModel $division,
        private DeclarationLegalEntityModel $legalEntity,
    ) {}
}
