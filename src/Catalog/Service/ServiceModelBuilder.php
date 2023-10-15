<?php

namespace App\Catalog\Service;

use App\Catalog\Entity\Service;
use App\Catalog\Model\Api\AbstractServiceModel;
use App\Catalog\Model\Api\ServiceGroupModel;
use App\Catalog\Model\Api\ServiceModel;
use Psr\Log\LoggerInterface;
use Throwable;

class ServiceModelBuilder
{
    public function __construct(
        private LoggerInterface $catalogApiLogger,
    ) {}

    public function buildServiceModel(Service $service): AbstractServiceModel
    {
        return $service->getServices()->getValues()
            ? new ServiceGroupModel(
                $service->getId(),
                $service->getName(),
                $service->getSlug(),
                $this->buildSubServices($service),
            )
            : new ServiceModel(
                $service->getId(),
                $service->getName(),
                $service->getSlug(),
                $service->getCode(),
                (float)$service->getPrice(),
                $service->getDetails()
            );
    }

    private function buildSubServices(Service $service): array
    {
        return array_filter(
            array_map(
                function (Service $service) {
                    try {
                        return $service->isActive() ? $this->buildServiceModel($service) : null;
                    } catch (Throwable $e) {
                        $this->catalogApiLogger->warning(__CLASS__.'->'.__METHOD__, ['message' => $e->getMessage()]);

                        return null;
                    }
                }, $service->getServices()->getValues()
            ),
        );
    }
}
