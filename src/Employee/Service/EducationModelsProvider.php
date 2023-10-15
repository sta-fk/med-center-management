<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Employee\Entity\EmployeeEducation;
use App\Employee\Model\Api\Collection\EducationModelCollection;
use App\Employee\Model\Api\EducationModel;

class EducationModelsProvider
{
    /**
     * @param EmployeeEducation[] $employeeEducations
     */
    public function getEmployeeEducationModels(array $employeeEducations): EducationModelCollection
    {
        $educationsCollection = new EducationModelCollection();

        array_map(
            function (EmployeeEducation $education) use ($educationsCollection){
                $educationsCollection->addEducation(
                    $this->buildEmployeeEducationModel($education));
            }, $employeeEducations
        );

        return $educationsCollection;
    }

    public function buildEmployeeEducationModel(EmployeeEducation $education): EducationModel
    {
        return new EducationModel(
            $education->getInstitutionName(),
            $education->getSpeciality(),
            $education->getDegree(),
        );
    }
}
