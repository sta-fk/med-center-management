<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Employee\Entity\Employee;
use App\Employee\Model\Api\Collection\EmployeeForListModelCollection;
use App\Employee\Model\Api\EmployeeShortModel;

class EmployeeShortModelsProvider
{
    /**
     * @param Employee[] $employees
     */
    public function getEmployeesModels(array $employees): EmployeeForListModelCollection
    {
        $employeesCollection = new EmployeeForListModelCollection();

        array_map(
            function (Employee $employee) use ($employeesCollection){
                $employeesCollection->addEmployee(
                    $this->buildEmployeeShortModel($employee));
            }, $employees
        );

        return $employeesCollection;
    }

    public function buildEmployeeShortModel(Employee $employee): EmployeeShortModel
    {
        return new EmployeeShortModel(
            $employee->getId(),
            $employee->getEmployeeInfo()->getFirstName(),
            $employee->getEmployeeInfo()->getLastName(),
            $employee->getEmployeeInfo()->getSlug(),
            $employee->getBrief(),
        );
    }
}
