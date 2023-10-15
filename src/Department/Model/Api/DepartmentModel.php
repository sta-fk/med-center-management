<?php declare(strict_types=1);

namespace App\Department\Model\Api;

class DepartmentModel
{
    public function __construct(
        private int $id,
        private string $slug,
        private string $name,
    ) {}
}
