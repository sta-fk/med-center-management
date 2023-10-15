<?php declare(strict_types=1);

namespace App\Catalog\Service;

use App\Catalog\Model\Api\DepartmentServicesModelCollection;
use App\Department\Entity\Department;
use App\Department\Repository\DepartmentRepository;
use App\Department\Service\DepartmentModelBuilder;

class DepartmentServicesProvider
{
    public function __construct(
        private DepartmentRepository $departmentRepository,
        private DepartmentModelBuilder $departmentModelBuilder,
    ) {}

    public function getDepartmentServicesExcludeWithoutDetails(): DepartmentServicesModelCollection
    {
        $departments = $this->departmentRepository->getActiveDepartmentsExcludeWithoutDetails();
//        $departments = $this->departmentRepository->getActiveDepartmentsWithServices();
        $serviceCollection = new DepartmentServicesModelCollection();

        array_map(function (Department $department) use ($serviceCollection) {
            $serviceCollection->addService(
                $this->departmentModelBuilder->buildDepartmentServicesModel($department)
            );
        }, $departments);

        return $serviceCollection;
    }

    public function getDepartmentServices(): DepartmentServicesModelCollection
    {
//        $departments = $this->departmentRepository->getActiveDepartmentsExcludeResearch();
        $departments = $this->departmentRepository->getActiveDepartmentsWithServices();
        $serviceCollection = new DepartmentServicesModelCollection();

        array_map(function (Department $department) use ($serviceCollection) {
            $serviceCollection->addService(
                $this->departmentModelBuilder->buildDepartmentServicesModel($department)
            );
        }, $departments);

        return $serviceCollection;
    }
}
