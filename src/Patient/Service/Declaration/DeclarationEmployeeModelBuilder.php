<?php declare(strict_types=1);

namespace App\Patient\Service\Declaration;

use App\Employee\Model\Ehealth\EmployeeShortInfoModel;
use App\Patient\Model\Api\Declaration\DeclarationEmployeeModel;

class DeclarationEmployeeModelBuilder
{
    public function getDeclarationEmployeeModel(array $employee): DeclarationEmployeeModel
    {
        return new DeclarationEmployeeModel(
            $employee['id'],
            $employee['employee_type'],
            $employee['status'],
            new \DateTimeImmutable($employee['start_date']),
            new \DateTimeImmutable($employee['end_date']),
            $this->createEmployeeInfoModel($employee['party']),
        );
    }

    private function createEmployeeInfoModel(array $employeeInfo): EmployeeShortInfoModel
    {
        return new EmployeeShortInfoModel(
            $employeeInfo['id'],
            $employeeInfo['first_name'],
            $employeeInfo['last_name'],
            $employeeInfo['second_name'],
        );
    }
}
