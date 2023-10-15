<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use App\Catalog\Enum\ServiceType;

class ServiceModel extends AbstractServiceModel
{
    public function __construct(
        int $id,
        string $name,
        string $slug,
        protected int $code,
        protected float $price,
        protected ?string $details,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function getType(): string
    {
        return ServiceType::SERVICE;
    }
}
