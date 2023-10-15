<?php declare(strict_types=1);

namespace App\Patient\Service\Patient;

use App\Patient\Model\Api\Patient\PatientInfoModel;

class PatientInfoModelBuilder
{
    public function getPatientInfoModel(array $patientInfo): PatientInfoModel
    {
        return new PatientInfoModel(
            $patientInfo['id'],
            $patientInfo['first_name'],
            $patientInfo['last_name'],
            $patientInfo['second_name']
        );
    }
}
