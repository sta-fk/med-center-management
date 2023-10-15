<?php declare(strict_types=1);

namespace App\Base\Model\Api;

use Symfony\Component\Validator\Constraints as Assert;

class ContactsModel
{
    public function __construct(
        private string $type,

        /**
         * @Assert\Regex("/^380\d{9}$/", message="api.contacts.phone_number_incorrect")
         */
        private string $phoneNumber,
    ) {}

    public function getType(): string
    {
        return $this->type;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}

