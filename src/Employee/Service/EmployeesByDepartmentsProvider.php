<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Department\Entity\Department;
use App\Department\Repository\DepartmentRepository;
use App\Employee\Entity\Employee;
use App\Employee\Model\Api\Collection\EmployeesByDepartmentsModelCollection;
use App\Employee\Model\Api\EmployeesByDepartmentsModel;
use App\Employee\Model\Api\EmployeeShortModel;
use App\Employee\Repository\EmployeeRepository;

class EmployeesByDepartmentsProvider
{
    public function __construct(
        private DepartmentRepository $departmentRepository,
        private EmployeeShortModelsProvider $employeeModelsProvider,
        private EmployeeRepository $employeeRepository,
    ) {}

    public function getAllEmployeesByDepartments(): EmployeesByDepartmentsModelCollection
    {
        $departments = $this->departmentRepository->getActiveDepartments();
//        $departments = $this->departmentRepository->getActiveDepartmentsWithEmployees();
        $departmentsWithEmployeesCollection = new EmployeesByDepartmentsModelCollection();

        array_map(function (Department $department) use ($departmentsWithEmployeesCollection) {
            $departmentsWithEmployeesCollection->addEmployeesByDepartments(
                new EmployeesByDepartmentsModel(
                    $department->getId(),
                    $department->getName(),
                    $department->getSlug(),
                    $this->employeeModelsProvider->getEmployeesModels(
                        $department->getEmployees()->getValues()
                    )->getEmployees()->getValues(),
                )
            );
        }, $departments);

        return $departmentsWithEmployeesCollection;
    }

    /**
     * @return EmployeeShortModel[]
     */
    public function getAllEmployeesByDepartmentId(int $departmentId): array
    {
        $employees = $this->employeeRepository->getActiveEmployeesByDepartmentId($departmentId);

        return array_map(function (Employee $employee) {
            return $this->employeeModelsProvider->buildEmployeeShortModel($employee);
        }, $employees);
    }
}
