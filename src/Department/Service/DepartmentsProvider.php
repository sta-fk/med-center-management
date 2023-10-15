<?php declare(strict_types=1);

namespace App\Department\Service;

use App\Department\Entity\Department;
use App\Department\Model\Api\DepartmentModel;
use App\Department\Repository\DepartmentRepository;

class DepartmentsProvider
{
    public function __construct(
        private DepartmentRepository $departmentRepository,
        private DepartmentModelBuilder $departmentModelBuilder,
    ) {}

    /**
     * @return DepartmentModel[]
     */
    public function provideDepartmentsModels(): array
    {
        $departments = $this->departmentRepository->getActiveDepartments();
//        $departments = $this->departmentRepository->getActiveDepartmentsWithServices();

        return array_map(
            function (Department $department) {
                return $this->departmentModelBuilder->buildDepartmentModel($department);
            }, $departments);
    }
}
