<?php

namespace App\Base\Service;

use App\Base\Model\Api\Collection\FullAddressModelCollection;
use App\Base\Model\Api\FullAddressModel;
use App\PatientUser\Entity\PatientAddress;

class FullAddressModelsProvider
{
    /**
     * @param PatientAddress[] $addresses
     */
    public function getAddressesModels(array $addresses): FullAddressModelCollection
    {
        $addressesCollection = new FullAddressModelCollection();

        array_map(
            function (PatientAddress $address) use ($addressesCollection) {
                $addressesCollection->addAddress($this->buildAddressModel($address));
            }, $addresses
        );

        return $addressesCollection;
    }

    public function buildAddressModel(PatientAddress $address): FullAddressModel
    {
        return new FullAddressModel(
            $address->getType(),
            $address->getCountry(),
            $address->getArea(),
            $address->getRegion(),
            $address->getSettlementType(),
            $address->getSettlement(),
            $address->getDistrict(),
            $address->getStreet(),
            $address->getHouse(),
            $address->getApartment(),
            $address->getZip(),
            $address->getComment(),
        );
    }

    public function getEhealthAddressModels(array $addresses): array
    {
        return array_map(
            function ($address) use ($addresses) {
                return new FullAddressModel(
                    $address['type'],
                    $address['country'],
                    $address['area'],
                    $address['region'],
                    $address['settlement_type'],
                    $address['settlement'],
                    null,
                    $address['street'],
                    $address['building'],
                    $address['apartment'],
                    $address['zip'],
                    null,
                );
            },
            $addresses
        );
    }
}
