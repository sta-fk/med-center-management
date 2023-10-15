<?php declare(strict_types=1);

namespace App\Base\Entity;

use Doctrine\ORM\Mapping as ORM;
use libphonenumber\PhoneNumber;

/** @ORM\MappedSuperclass */
abstract class AbstractContacts
{
    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $type;

    /**
     * @ORM\Column(type="phone_number")
     */
    protected $phoneNumber;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }
}
