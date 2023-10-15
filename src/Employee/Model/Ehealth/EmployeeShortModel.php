<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class EmployeeShortModel
{
    public function __construct(
        private string $id,
        private string $employeeType,
        private string $status,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $startDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $endDate,

        private EmployeeShortInfoModel $employeeInfo,

        /**
         * @var SpecialityModel[]
         *
         * @JMS\Type("array<App\Employee\Model\Ehealth\SpecialityModel>")
         * @JMS\Exclude(if="object.getSpecialities() === null")
         */
        private ?array $specialities = null,

        /**
         * @JMS\Exclude(if="object.getDivision() === null")
         */
        private ?DivisionModel $division = null,

        /**
         * @JMS\Exclude(if="object.getLegalEntity() === null")
         */
        private ?LegalEntityModel $legalEntity = null,
    ) {}

    public function getSpecialities(): ?array
    {
        return $this->specialities;
    }

    public function getDivision(): ?DivisionModel
    {
        return $this->division;
    }

    public function getLegalEntity(): ?LegalEntityModel
    {
        return $this->legalEntity;
    }
}
