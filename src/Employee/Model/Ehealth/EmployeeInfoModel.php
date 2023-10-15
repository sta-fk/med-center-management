<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

use App\Base\Model\Api\ContactsModel;
use JMS\Serializer\Annotation as JMS;

class EmployeeInfoModel
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $secondName,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $birthDate,

        private bool $gender,
        private string $inn,

        /**
         * @var ContactsModel[]
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        private int $workingExperience,
        private string $aboutMyself,
        private int $declarationLimit,
        private int $declarationCount,
    ) {}
}
