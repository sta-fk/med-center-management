<?php declare(strict_types=1);

namespace App\Base\Model\Api\Collection;

use App\Base\Model\Api\ContactsModel;
use Doctrine\Common\Collections\ArrayCollection;

class ContactsModelCollection
{
    /**
     * @var ContactsModel[]|ArrayCollection
     */
    private ArrayCollection|array $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function addContacts(ContactsModel $contactsModel): void
    {
        if (!$this->contacts->contains($contactsModel)) {
            $this->contacts->add($contactsModel);
        }
    }

    public function getContacts(): ArrayCollection|array
    {
        return $this->contacts;
    }
}
