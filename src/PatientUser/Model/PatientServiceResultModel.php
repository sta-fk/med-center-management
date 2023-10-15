<?php declare(strict_types=1);

namespace App\PatientUser\Model;

/**
 * Class is pdf data
 */
class PatientServiceResultModel
{
    public function __construct(
        public int $id,
        public string $date,
        public string $patientName,
        public string $birthDate,
        public string $serviceName,
        public string $fileName,
        public array $result,
    ) {}
}
