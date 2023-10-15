<?php declare(strict_types=1);

namespace App\Patient\Model\Api\Patient;

class PatientInfoModel
{
    public function __construct(
        private string $id,
        private string $firstName,
        private string $lastName,
        private string $secondName,
    ) {}
}
