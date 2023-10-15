<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Division\Service\DivisionModelBuilder;
use App\Employee\Entity\Employee;
use App\Employee\Model\Api\EmployeeModel;
use App\LegalEntity\Service\LegalEntityModelBuilder;

class EmployeeModelBuilder
{
    public function __construct(
        private EmployeeInfoModelBuilder $infoModelBuilder,
        private DivisionModelBuilder $divisionModelBuilder,
        private LegalEntityModelBuilder $legalEntityModelBuilder,
        private EducationModelsProvider $educationModelsProvider,
        private QualificationModelsProvider $qualificationModelsProvider,
        private SpecialityModelsProvider $specialityModelsProvider,
    ) {}

    public function buildEmployeeModel(Employee $employee): EmployeeModel
    {
        $educations =
            $this->educationModelsProvider->getEmployeeEducationModels(
                $employee->getEducations()->getValues()
            )->getEducations()->getValues();

        $qualifications =
            $this->qualificationModelsProvider->getEmployeeQualificationModels(
                $employee->getQualifications()->getValues()
            )->getQualifications()->getValues();

        $specialities = $this->specialityModelsProvider->getEmployeeSpecialityModels(
            $employee->getSpecialities()->getValues()
        )->getSpecialities()->getValues();

        return new EmployeeModel(
            $employee->getStartDate(),
            $employee->getEndDate() ?? new \DateTimeImmutable('now'),
            $this->infoModelBuilder->buildEmployeeInfoModel($employee->getEmployeeInfo()),
            $employee->getBrief(),
            $this->divisionModelBuilder->buildDivisionModel($employee->getDivision()),
            $this->legalEntityModelBuilder->buildLegalEntityModel($employee->getLegalEntity()),
            $educations,
            $qualifications,
            $specialities,
        );
    }
}
