<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\ScienceDegreeModel;

class ScienceDegreeModelBuilder
{
    public function buildScienceDegreeModel(array $scienceDegree): ScienceDegreeModel
    {
        return new ScienceDegreeModel(
            $scienceDegree['country'],
            $scienceDegree['city'],
            $scienceDegree['degree'],
            $scienceDegree['institution_name'],
            $scienceDegree['speciality'],
            new \DateTimeImmutable($scienceDegree['issued_date']),
        );
    }
}
