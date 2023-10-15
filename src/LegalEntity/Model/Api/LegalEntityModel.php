<?php declare(strict_types=1);

namespace App\LegalEntity\Model\Api;

class LegalEntityModel
{
    public function __construct(
        private string $name,
        private string $edrpou,
        private string $status,
    ) {}
}
