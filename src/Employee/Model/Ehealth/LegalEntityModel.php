<?php declare(strict_types=1);

namespace App\Employee\Model\Ehealth;

class LegalEntityModel
{
    public function __construct(
        private string $id,
        private string $name,
        private string $edrpou,
        private string $status,
    ) {}
}
