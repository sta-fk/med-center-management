<?php declare(strict_types=1);

namespace App\PatientUser\Manager;

use App\PatientUser\Entity\PatientProfile;
use App\PatientUser\Model\Api\Request\PatientServiceResultModel;
use App\PatientUser\Repository\PatientServiceResultRepository;
use App\PatientUser\Service\PatientServiceResultService;
use App\PatientUser\Service\PatientServiceResultValidator;

class PatientServiceResultManager
{
    public function __construct(
        private PatientServiceResultService $patientServiceResultService,
        private PatientServiceResultValidator $validator,
        private PatientServiceResultRepository $patientServiceResultRepository,
    ) {}

    public function create(PatientProfile $patientProfile, PatientServiceResultModel $requestResultModel): void
    {
        $this->validator->validatePatientServiceResultModel($requestResultModel);

        $patientResult = $this->patientServiceResultService->createPatientServiceResult($patientProfile, $requestResultModel);

        $this->patientServiceResultRepository->add($patientResult, true);
    }
}
