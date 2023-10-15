<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Employee\Model\Ehealth\EmployeeModel;

class EmployeeModelBuilder
{
    public function __construct(
        private EmployeeInfoModelBuilder $infoModelBuilder,
        private DivisionModelBuilder $divisionModelBuilder,
        private LegalEntityModelBuilder $legalEntityModelBuilder,
        private EducationModelBuilder $educationModelBuilder,
        private QualificationModelBuilder $qualificationModelBuilder,
        private SpecialityModelBuilder $specialityModelBuilder,
        private ScienceDegreeModelBuilder $scienceDegreeModelBuilder,
    ) {}

    public function getAllEmployeeDetailsModels(array $employees): array
    {
        return array_map(
            [$this, 'buildEmployeeModel'],
            $employees
        );
    }

    public function buildEmployeeModel(array $employee): EmployeeModel
    {
        return new EmployeeModel(
            $employee['id'],
            $employee['employee_type'],
            $employee['status'],
            $employee['is_active'],
            new \DateTimeImmutable($employee['start_date']),
            new \DateTimeImmutable($employee['end_date']),
            null,
            $this->infoModelBuilder->buildEmployeeInfoModel($employee['party']),
            $this->educationModelBuilder->getAllEducationModels($employee['doctor']['educations']),
            $this->qualificationModelBuilder->getAllQualificationModels($employee['doctor']['qualifications']),
            $this->specialityModelBuilder->getAllSpecialityModels($employee['doctor']['specialities']),
            $this->scienceDegreeModelBuilder->buildScienceDegreeModel($employee['doctor']['science_degree']),
            $this->divisionModelBuilder->buildDivisionModel($employee['division']),
            $this->legalEntityModelBuilder->buildLegalEntityModel($employee['legal_entity']),
        );
    }
}
