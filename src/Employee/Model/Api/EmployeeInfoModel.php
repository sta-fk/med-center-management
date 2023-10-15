<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

use App\Base\Model\Api\ContactsModel;
use JMS\Serializer\Annotation as JMS;

class EmployeeInfoModel
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private string $secondName,

        /**
         * @var ContactsModel[]
         * @JMS\Type("array<App\Base\Model\Api\ContactsModel>")
         */
        private array $phones,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d'>")
         */
        private \DateTimeImmutable $birthDate,

        private int $workingExperience,
        private int $declarationCount,
        private string $aboutMyself,
    ) {}
}
