<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use App\Catalog\Enum\ServiceType;
use JMS\Serializer\Annotation as JMS;

class ServiceGroupModel extends AbstractServiceModel
{
    public function __construct(
        int $id,
        string $name,
        string $slug,

        /**
         * @var AbstractServiceModel[]
         *
         * @JMS\Type("array<App\Catalog\Model\Api\AbstractServiceModel>")
         */
        protected array $items,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function getType(): string
    {
        return ServiceType::SERVICE_GROUP;
    }
}
