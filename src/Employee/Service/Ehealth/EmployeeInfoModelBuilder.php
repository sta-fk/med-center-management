<?php declare(strict_types=1);

namespace App\Employee\Service\Ehealth;

use App\Base\Service\ContactsModelsProvider;
use App\Employee\Model\Ehealth\EmployeeInfoModel;

class EmployeeInfoModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
    ) {}

    public function buildEmployeeInfoModel(array $employeeInfo): EmployeeInfoModel
    {
        return new EmployeeInfoModel(
            $employeeInfo['first_name'],
            $employeeInfo['last_name'],
            $employeeInfo['second_name'],
            new \DateTimeImmutable($employeeInfo['birth_date']),
            $this->formatGender($employeeInfo['gender']),
            $employeeInfo['tax_id'],
            $this->contactsModelsProvider->getEhealthContactsModels($employeeInfo['phones']),
            $employeeInfo['working_experience'],
            $employeeInfo['about_myself'],
            $employeeInfo['declaration_limit'],
            $employeeInfo['declaration_count'],
        );
    }

    private function formatGender(string $gender): bool
    {
        return match($gender) {
            'MALE' => false,
            'FEMALE' => true,
        };
    }
}
