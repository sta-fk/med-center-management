<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use Doctrine\Common\Collections\ArrayCollection;

class PriceListCollection
{
    /**
     * @var PriceListContentModel[]|ArrayCollection
     */
    private ArrayCollection|array $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function addService(PriceListContentModel $serviceGroup): void
    {
        if (!$this->services->contains($serviceGroup)) {
            $this->services->add($serviceGroup);
        }
    }

    public function getServices(): ArrayCollection|array
    {
        return $this->services;
    }
}
