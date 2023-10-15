<?php declare(strict_types=1);

namespace App\Base\Model\Api;

use Symfony\Component\Validator\Constraints as Assert;

class FullAddressModel
{
    public function __construct(
        private string $type,
        private string $country,
        private string $area,
        private string $region,
        private string $settlementType,
        private string $settlement,
        private ?string $district,
        private ?string $street,
        private ?string $house,
        private ?string $apartment,

        /**
         * @Assert\Regex("/^\d{5}$/", message="api.address.zip_incorrect")
         */
        private ?string $zip,

        private ?string $comment,
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getArea(): string
    {
        return $this->area;
    }

    public function getRegion(): string
    {
        return $this->region;
    }

    public function getSettlementType(): string
    {
        return $this->settlementType;
    }

    public function getSettlement(): string
    {
        return $this->settlement;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
