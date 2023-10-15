<?php declare(strict_types=1);

namespace App\Employee\Model\Api;

class EducationModel
{
    public function __construct(
        private string $institutionName,
        private string $speciality,
        private string $degree,
    ) {}
}
