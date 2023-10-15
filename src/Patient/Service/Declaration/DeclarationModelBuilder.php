<?php declare(strict_types=1);

namespace App\Patient\Service\Declaration;

use App\Patient\Model\Api\Declaration\DeclarationModel;

class DeclarationModelBuilder
{
    public function __construct(
        private DeclarationPatientModelBuilder $patientModelBuilder,
        private DeclarationEmployeeModelBuilder $employeeModelBuilder,
        private DeclarationDivisionModelBuilder $divisionModelBuilder,
        private DeclarationLegalEntityModelBuilder $legalEntityModelBuilder,
    ) {}

    public function getDeclarationModel(array $declaration): DeclarationModel
    {
        return new DeclarationModel(
            $declaration['id'],
            $declaration['declaration_number'],
            $declaration['status'],
            $declaration['scope'],
            new \DateTimeImmutable($declaration['start_date']),
            new \DateTimeImmutable($declaration['end_date']),
            $this->patientModelBuilder->getDeclarationPatientModel($declaration['person']),
            $this->employeeModelBuilder->getDeclarationEmployeeModel($declaration['employee']),
            $this->divisionModelBuilder->getDeclarationDivisionModel($declaration['division']),
            $this->legalEntityModelBuilder->getDeclarationLegalEntityModel($declaration['legal_entity']),
        );
    }
}
