<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\EducationModel;

class EducationModelBuilder
{
    public function getAllEducationModels(array $educations): array
    {
        return array_map(
            [$this, 'buildEducationModel'],
            $educations
        );
    }

    public function buildEducationModel(array $education): EducationModel
    {
        return new EducationModel(
            $education['country'],
            $education['city'],
            $education['institution_name'],
            new \DateTimeImmutable($education['issued_date']),
            $education['degree'],
            $education['speciality'],
        );
    }
}
