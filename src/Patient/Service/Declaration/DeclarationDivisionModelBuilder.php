<?php declare(strict_types=1);

namespace App\Patient\Service\Declaration;

use App\Base\Service\ContactsModelsProvider;
use App\Base\Service\FullAddressModelsProvider;
use App\Patient\Model\Api\Declaration\DeclarationDivisionModel;

class DeclarationDivisionModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
        private FullAddressModelsProvider $addressModelsProvider,
    ) {}

    public function getDeclarationDivisionModel(array $division): DeclarationDivisionModel
    {
        return new DeclarationDivisionModel(
            $division['id'],
            $division['name'],
            $division['email'],
            $this->contactsModelsProvider->getEhealthContactsModels($division['phones']),
            $this->addressModelsProvider->getEhealthAddressModels($division['addresses']),
        );
    }
}
