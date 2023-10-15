<?php declare(strict_types=1);

namespace App\Patient\Service;

use App\Patient\Api\PatientClient;
use App\Patient\Exception\PatientNotFoundInEhealthException;
use App\PatientUser\Model\Api\Request\PatientProfileModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PatientSearchService
{
    public function __construct(
        private PatientClient $patientClient,
        private LoggerInterface $patientEhealthLogger,
    ) {}

    public function searchPatientInEhealth(PatientProfileModel $profileModel): string
    {
        try {
            $patient = $this->patientClient->searchPatient(
                [
                    'first_name' => $profileModel->getFirstName(),
                    'last_name' => $profileModel->getLastName(),
                    'birth_date' => $profileModel->getBirthDate(),
                ]
            );
        } catch (\Throwable $e) {
            $this->patientEhealthLogger->error(__METHOD__ . ': ' . $e->getMessage());

            throw new PatientNotFoundInEhealthException();
        }

        return array_key_exists(0, $patient)
            ? $patient[0]['id']
            : throw new PatientNotFoundInEhealthException();
    }
}
