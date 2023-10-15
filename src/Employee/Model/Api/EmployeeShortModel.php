<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

class EmployeeShortModel
{
    public function __construct(
        private int $id,
        private string $firstName,
        private string $lastName,
        private string $slug,
        private string $brief,
    ) {}
}
