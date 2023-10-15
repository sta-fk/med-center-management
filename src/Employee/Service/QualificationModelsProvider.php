<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Employee\Entity\EmployeeQualification;
use App\Employee\Model\Api\Collection\QualificationModelCollection;
use App\Employee\Model\Api\QualificationModel;

class QualificationModelsProvider
{
    /**
     * @param QualificationModel[] $employeeQualifications
     */
    public function getEmployeeQualificationModels(array $employeeQualifications): QualificationModelCollection
    {
        $qualificationCollection = new QualificationModelCollection();

        array_map(
            function (EmployeeQualification $qualification) use ($qualificationCollection){
                $qualificationCollection->addQualification(
                    $this->buildEmployeeQualificationModel($qualification));
            }, $employeeQualifications
        );

        return $qualificationCollection;
    }

    public function buildEmployeeQualificationModel(EmployeeQualification $qualification): QualificationModel
    {
        return new QualificationModel(
            $qualification->getSpeciality(),
            $qualification->getInstitutionName(),
            $qualification->getValidTo(),
        );
    }
}
