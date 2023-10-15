<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

class EmployeeShortInfoModel
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $patronymic,
        private ?bool $hasInn = null,
        private ?int $declarationLimit = null,
        private ?int $declarationCount = null,
    ) {}
}
