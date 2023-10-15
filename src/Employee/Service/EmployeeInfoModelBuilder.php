<?php declare(strict_types=1);

namespace App\Employee\Service;

use App\Base\Service\ContactsModelsProvider;
use App\Employee\Entity\EmployeeInfo;
use App\Employee\Model\Api\EmployeeInfoModel;

class EmployeeInfoModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
    ) {}

    public function buildEmployeeInfoModel(EmployeeInfo $employeeInfo): EmployeeInfoModel
    {
        $contacts = $this->contactsModelsProvider->getContactsModels(
            $employeeInfo->getPhones()->getValues()
        )->getContacts()->getValues()
        ;

        return new EmployeeInfoModel(
            $employeeInfo->getFirstName(),
            $employeeInfo->getLastName(),
            $employeeInfo->getPatronymic(),
            $contacts,
            $employeeInfo->getBirthDate(),
            $employeeInfo->getWorkingExperience(),
            $employeeInfo->getDeclarationCount(),
            $employeeInfo->getAboutMyself(),
        );
    }
}
