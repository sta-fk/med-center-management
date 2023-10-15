<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\QualificationModel;

class QualificationModelBuilder
{
    public function getAllQualificationModels(array $qualifications): array
    {
        return array_map(
            [$this, 'buildQualificationModel'],
            $qualifications
        );
    }

    public function buildQualificationModel(array $qualification): QualificationModel
    {
        return new QualificationModel(
            $qualification['type'],
            $qualification['institution_name'],
            $qualification['speciality'],
            new \DateTimeImmutable($qualification['issued_date']),
            new \DateTimeImmutable($qualification['valid_to']),
            $qualification['additional_info'],
        );
    }
}
