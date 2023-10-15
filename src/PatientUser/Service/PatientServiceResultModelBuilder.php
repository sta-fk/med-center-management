<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\PatientUser\Entity\PatientServiceResult;
use App\PatientUser\Model\Api\Response\PatientServiceResultModel as PatientServiceResultApiModel;
use App\PatientUser\Model\PatientServiceResultModel as PatientServiceResultPdfModel;

class PatientServiceResultModelBuilder
{
    public function buildPatientServiceResultModel(PatientServiceResult $patientServiceResult): PatientServiceResultApiModel
    {
        return new PatientServiceResultApiModel(
            $patientServiceResult->getService()->getName(),
            $patientServiceResult->getDate(),
            $this->generateResultPdfUrl(
                $patientServiceResult->getPatient()->getUser()->getId(),
                $patientServiceResult->getService()->getSlug(),
                $patientServiceResult->getDate(),
            )
        );
    }

    public function buildPatientServiceResultPdfModel(PatientServiceResult $patientServiceResult): PatientServiceResultPdfModel
    {
        $patientName = sprintf(
            '%s %s %s',
            $patientServiceResult->getPatient()->getLastName(),
            $patientServiceResult->getPatient()->getFirstName(),
            $patientServiceResult->getPatient()->getPatronymic(),
        );

        $fileName = sprintf(
            '%s_%s',
            $patientServiceResult->getService()->getSlug(),
            $patientServiceResult->getDate()->format('d-m-Y'),
        );

        return new PatientServiceResultPdfModel(
            $patientServiceResult->getId(),
            $patientServiceResult->getDate()->format('d.m.Y'),
            $patientName,
            $patientServiceResult->getPatient()->getAdditionalInfo()->getBirthDate()->format('d.m.Y'),
            $patientServiceResult->getService()->getName(),
            $fileName,
            $patientServiceResult->getResult(),
        );
    }

    private function generateResultPdfUrl(int $userId, string $serviceSlug, \DateTimeImmutable $date): string
    {
        return sprintf('/api/patient/%s/%s/%s', $userId, $serviceSlug, $date->format('d-m-Y'));
    }
}
