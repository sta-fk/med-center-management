<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use JMS\Serializer\Annotation as JMS;

class PriceListContentModel
{
    public function __construct(
        private string $name,
        private string $slug,

        /**
         * @var AbstractServiceModel[]
         *
         * @JMS\Type("array<App\Catalog\Model\Api\AbstractServiceModel>")
         */
        private array $items,
    ) {}
}
