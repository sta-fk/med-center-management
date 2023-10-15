<?php declare(strict_types=1);

namespace App\Patient\Service\Declaration;

use App\Base\Service\ContactsModelsProvider;
use App\Patient\Model\Api\Declaration\DeclarationLegalEntityModel;
use App\Base\Service\FullAddressModelsProvider;

class DeclarationLegalEntityModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
        private FullAddressModelsProvider $addressModelsProvider,
    ) {}

    public function getDeclarationLegalEntityModel(array $legalEntity): DeclarationLegalEntityModel
    {
        return new DeclarationLegalEntityModel(
            $legalEntity['id'],
            $legalEntity['public_name'],
            $legalEntity['edrpou'],
            $legalEntity['status'],
            $legalEntity['email'],
            $this->contactsModelsProvider->getEhealthContactsModels($legalEntity['phones']),
            $this->addressModelsProvider->getEhealthAddressModels($legalEntity['addresses']),
        );
    }
}
