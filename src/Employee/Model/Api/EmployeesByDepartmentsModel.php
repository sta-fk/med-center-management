<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

use JMS\Serializer\Annotation as JMS;

class EmployeesByDepartmentsModel
{
    public function __construct(
        private int $id,
        private string $name,
        private string $slug,

        /**
         * @var EmployeeShortModel[]
         *
         * @JMS\Type("array<App\Employee\Model\Api\EmployeeShortModel>")
         * @JMS\SerializedName("items")
         */
        private array $employees,
    ) {}
}
