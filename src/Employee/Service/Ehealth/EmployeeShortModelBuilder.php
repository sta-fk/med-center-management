<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\EmployeeShortModel;
use App\Employee\Model\Ehealth\EmployeeShortInfoModel;

class EmployeeShortModelBuilder
{
    public function __construct(
        private SpecialityModelBuilder $specialityModelBuilder,
        private DivisionModelBuilder $divisionModelBuilder,
        private LegalEntityModelBuilder $legalEntityModelBuilder,
    ) {}

    public function getAllEmployeeModels(array $employees): array
    {
        return array_map(
            [$this, 'buildEmployeeModel'],
            $employees
        );
    }

    public function buildEmployeeModel(array $employeeDetails): EmployeeShortModel
    {
        return new EmployeeShortModel(
            $employeeDetails['id'],
            $employeeDetails['employee_type'],
            $employeeDetails['status'],
            new \DateTimeImmutable($employeeDetails['start_date']),
            new \DateTimeImmutable($employeeDetails['end_date']),
            $this->createEmployeeInfoFromListModel($employeeDetails['party']),
            $this->specialityModelBuilder->getAllSpecialityModels($employeeDetails['doctor']['specialities']),
            $this->divisionModelBuilder->buildDivisionModel($employeeDetails['division']),
            $this->legalEntityModelBuilder->buildLegalEntityModel($employeeDetails['legal_entity']),
        );
    }

    private function createEmployeeInfoFromListModel(array $employeeInfo): EmployeeShortInfoModel
    {
        return new EmployeeShortInfoModel(
            $employeeInfo['id'],
            $employeeInfo['first_name'],
            $employeeInfo['last_name'],
            $employeeInfo['second_name'],
            !$employeeInfo['no_tax_id'],
            $employeeInfo['declaration_limit'],
            $employeeInfo['declaration_count'],
        );
    }
}
