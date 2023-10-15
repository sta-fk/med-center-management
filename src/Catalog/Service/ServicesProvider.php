<?php declare(strict_types=1);

namespace App\Catalog\Service;

use App\Catalog\Entity\Service;
use App\Catalog\Model\Api\AbstractServiceModel;
use App\Catalog\Repository\ServiceRepository;

class ServicesProvider
{
    public function __construct(
        private ServiceRepository   $serviceRepository,
        private ServiceModelBuilder $serviceModelBuilder,
    ) {}

    /**
     * @return AbstractServiceModel[]
     */
    public function getResearchModels(): array
    {
        $researches = $this->serviceRepository->getResearches();

        return array_map(
            function (Service $service) {
                return $this->serviceModelBuilder->buildServiceModel($service);
            }, $researches
        );
    }

    /**
     * @return AbstractServiceModel[]
     */
    public function getServicesByDepartmentId(int $id): array
    {
        $services = $this->serviceRepository->getServicesByDepartmentId($id);

        return array_map(
            function (Service $service) {
                return $this->serviceModelBuilder->buildServiceModel($service);
            }, $services
        );
    }

    /**
     * @param Service[]
     *
     * @return AbstractServiceModel[]
     */
    public function getServiceModels(array $services): array
    {
        return array_map(
            function (Service $service) {
                return $this->serviceModelBuilder->buildServiceModel($service);
            }, $services
        );
    }
}
