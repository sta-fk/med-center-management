<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use JMS\Serializer\Annotation as JMS;

class EmployeeModel
{
    public function __construct(
        private string $id,
        private string $employeeType,
        private string $status,
        private bool $isActive,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $startDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private ?\DateTimeImmutable $endDate,

        private ?string $brief,
        private EmployeeInfoModel $employeeInfo,

        /**
         * @var EducationModel[]
         * @JMS\Type("array<App\Employee\Model\Ehealth\EducationModel>")
         */
        private array $educations,

        /**
         * @var QualificationModel[]
         * @JMS\Type("array<App\Employee\Model\Ehealth\QualificationModel>")
         */
        private array $qualifications,
        /**
         * @var SpecialityModel[]
         * @JMS\Type("array<App\Employee\Model\Ehealth\SpecialityModel>")
         */
        private array $specialities,
        private ScienceDegreeModel $degree,
        private DivisionModel $division,
        private LegalEntityModel $legalEntity,
    ) {}
}
