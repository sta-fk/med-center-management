<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request;

use App\Api\Request\ModelArgumentValueInterface;
use App\Base\Model\Api\ContactsModel;
use App\Base\Model\Api\FullAddressModel;
use App\PatientUser\Model\Api\Request\Documents\PatientDocumentModel;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class PatientProfileModel implements ModelArgumentValueInterface
{
    public function __construct(
        /**
         * @Assert\NotBlank()
         */
        private string $firstName,

        /**
         * @Assert\NotBlank()
         */
        private string $lastName,

        /**
         * @Assert\NotBlank()
         */
        private string $patronymic,

        /**
         * @Assert\NotBlank()
         *
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $birthDate,

        /**
         * @Assert\NotBlank()
         */
        private string $birthCountry,

        /**
         * @Assert\NotBlank()
         */
        private string $birthCity,

        /**
         * @var ContactsModel[]
         *
         * @Assert\NotBlank()
         * @Assert\Valid
         *
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        /**
         * @var FullAddressModel[]
         *
         * @Assert\NotBlank()
         * @Assert\Valid
         *
         * @JMS\Type("array<App\Base\Model\Api\FullAddressModel>")
         */
        private array $addresses,

        /**
         * @Assert\NotBlank()
         * @Assert\Valid
         */
        private PatientDocumentModel $documents,
    ) {}

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function getBirthCountry(): string
    {
        return $this->birthCountry;
    }

    public function getBirthCity(): string
    {
        return $this->birthCity;
    }

    /**
     * @return ContactsModel[]
     */
    public function getPhones(): array
    {
        return $this->phones;
    }

    /**
     * @return FullAddressModel[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    public function getDocuments(): PatientDocumentModel
    {
        return $this->documents;
    }
}
