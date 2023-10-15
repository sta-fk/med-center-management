<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

use App\Division\Model\Api\DivisionModel;
use App\LegalEntity\Model\Api\LegalEntityModel;
use JMS\Serializer\Annotation as JMS;

class EmployeeModel
{
    public function __construct(
        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $startDate,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $endDate,

        private EmployeeInfoModel $employeeInfo,
        private string $brief,
        private DivisionModel $division,
        private LegalEntityModel $legalEntity,

        /**
         * @var EducationModel[]
         * @JMS\Type("array<App\Employee\Model\Api\EducationModel>")
         */
        private array $educations,

        /**
         * @var QualificationModel[]
         * @JMS\Type("array<App\Employee\Model\Api\QualificationModel>")
         */
        private array $qualifications,

        /**
         * @var SpecialityModel[]
         * @JMS\Type("array<App\Employee\Model\Api\SpecialityModel>")
         */
        private array $specialities,
    ) {}
}
