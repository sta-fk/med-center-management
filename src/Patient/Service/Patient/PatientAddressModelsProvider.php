<?php declare(strict_types=1);

namespace App\Patient\Service\Patient;

use App\Patient\Model\Api\Patient\PatientAddressModel;

class PatientAddressModelsProvider
{
    public function getPatientAddresses(array $addresses): array
    {
        return array_map(
            function ($address) use ($addresses) {
                return new PatientAddressModel(
                    $address['country'],
                    $address['area'],
                    $address['region'],
                    $address['settlement_type'],
                    $address['settlement'],
                );
            },
            $addresses
        );
    }
}
