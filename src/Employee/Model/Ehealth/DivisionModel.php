<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

class DivisionModel
{
    public function __construct(
        private string $id,
        private string $name,
        private string $type,
        private string $status,
        private bool $dlsVerified,
    ) {}
}
