<?php declare(strict_types=1);

namespace App\Base\Model\Api\Collection;

use App\Base\Model\Api\FullAddressModel;
use Doctrine\Common\Collections\ArrayCollection;

class FullAddressModelCollection
{
    /**
     * @var FullAddressModel[]|ArrayCollection
     */
    private ArrayCollection|array $addresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
    }

    public function addAddress(FullAddressModel $addressModel): void
    {
        if (!$this->addresses->contains($addressModel)) {
            $this->addresses->add($addressModel);
        }
    }

    public function getAddresses(): ArrayCollection|array
    {
        return $this->addresses;
    }
}
