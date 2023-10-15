<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use Doctrine\Common\Collections\ArrayCollection;

class DepartmentServicesModelCollection
{
    /**
     * @var DepartmentServicesModel[]|ArrayCollection
     */
    private ArrayCollection|array $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
    }

    public function addService(DepartmentServicesModel $servicesModel): void
    {
        if (!$this->services->contains($servicesModel)) {
            $this->services->add($servicesModel);
        }
    }

    public function getServices(): ArrayCollection|array
    {
        return $this->services;
    }
}
