<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Patient;

class PatientAddressModel
{
    public function __construct(
        private string $country,
        private string $area,
        private string $region,
        private string $settlementType,
        private string $settlement,
    ) {}
}
