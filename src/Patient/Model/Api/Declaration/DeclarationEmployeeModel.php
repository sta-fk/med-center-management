<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Declaration;

use App\Employee\Model\Ehealth\EmployeeShortInfoModel;
use JMS\Serializer\Annotation as JMS;

class DeclarationEmployeeModel
{
    public function __construct(
        private string $id,
        private string $employeeType,
        private string $status,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $startDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $endDate,

        private EmployeeShortInfoModel $employeeInfo,
    ) {}
}
