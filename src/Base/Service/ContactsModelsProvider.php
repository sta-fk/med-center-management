<?php declare(strict_types=1);

namespace App\Base\Service;

use App\Base\Entity\AbstractContacts;
use App\Base\Model\Api\Collection\ContactsModelCollection;
use App\Base\Model\Api\ContactsModel;

class ContactsModelsProvider
{
    /**
     * @param AbstractContacts[] $contacts
     */
    public function getContactsModels(array $contacts): ContactsModelCollection
    {
        $contactsCollection = new ContactsModelCollection();

        array_map(
            function (AbstractContacts $contact) use ($contactsCollection){
                $contactsCollection->addContacts($this->buildContactsModel($contact));
            }, $contacts
        );

        return $contactsCollection;
    }

    public function buildContactsModel(AbstractContacts $contacts): ContactsModel
    {
        return new ContactsModel(
            $contacts->getType(),
            $contacts->getPhoneNumber()->getCountryCode() . $contacts->getPhoneNumber()->getNationalNumber()
        );
    }

    public function getEhealthContactsModels(array $phones): array
    {
        return array_map(
            function ($phone) use ($phones) {
                return new ContactsModel(
                    $phone['type'],
                    $phone['number'],
                );
            },
            $phones
        );
    }
}
