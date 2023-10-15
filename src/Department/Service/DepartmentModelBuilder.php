<?php declare(strict_types=1);

namespace App\Department\Service;

use App\Catalog\Model\Api\DepartmentServicesModel;
use App\Catalog\Service\ServicesProvider;
use App\Department\Entity\Department;
use App\Department\Model\Api\DepartmentModel;

class DepartmentModelBuilder
{
    public function __construct(
        private ServicesProvider $serviceProvider,
    ) {}

    public function buildDepartmentServicesModel(Department $department): DepartmentServicesModel
    {
        return new DepartmentServicesModel(
            $department->getId(),
            $department->getName(),
            $department->getSlug(),
            $this->serviceProvider->getServiceModels($department->getServices()->getValues()),
        );
    }

    public function buildDepartmentModel(Department $department): DepartmentModel
    {
        return new DepartmentModel(
            $department->getId(),
            $department->getSlug(),
            $department->getName(),
        );
    }
}
