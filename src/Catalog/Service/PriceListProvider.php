<?php declare(strict_types=1);

namespace App\Catalog\Service;

use App\Catalog\Enum\PriceListContent;
use App\Catalog\Model\Api\PriceListCollection;
use App\Catalog\Model\Api\PriceListContentModel;

class PriceListProvider
{
    public function __construct(
        private DepartmentServicesProvider $departmentServicesProvider,
        private ServicesProvider $servicesProvider,
    ) {}

    public function getPriceList(): PriceListCollection
    {
        $services = new PriceListCollection();

        $services->addService(
            new PriceListContentModel(
                PriceListContent::SERVICE,
                PriceListContent::SERVICE_SLUG,
                $this->departmentServicesProvider->getDepartmentServices()->getServices()->getValues(),
            )
        );

        $services->addService(
            new PriceListContentModel(
                PriceListContent::RESEARCH,
                PriceListContent::RESEARCH_SLUG,
                $this->servicesProvider->getResearchModels(),
            )
        );

        return $services;
    }
}
