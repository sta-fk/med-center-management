<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\SpecialityModel;

class SpecialityModelBuilder
{
    public function getAllSpecialityModels(array $specialities): array
    {
        return array_map(
            [$this, 'buildSpecialityModel'],
            $specialities
        );
    }

    public function buildSpecialityModel(array $speciality): SpecialityModel
    {
        return new SpecialityModel(
            $speciality['speciality'],
            $speciality['speciality_officio'],
            $speciality['level'],
            $speciality['qualification_type'],
            $speciality['attestation_name'],
            $speciality['attestation_date'],
            new \DateTimeImmutable($speciality['valid_to_date']),
        );
    }
}
