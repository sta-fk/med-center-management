<?php declare(strict_types=1);

namespace App\Patient\Service\Patient;

use App\Base\Service\ContactsModelsProvider;
use App\Patient\Model\Api\Patient\PatientDetailsModel;

class PatientDetailsModelBuilder
{
    public function __construct(
        private ContactsModelsProvider $contactsModelsProvider,
        private PatientAddressModelsProvider $addressModelsProvider,
    ) {}

    public function getPatientInfoModel(array $patientInfo): PatientDetailsModel
    {
        return new PatientDetailsModel(
            $patientInfo['id'],
            $patientInfo['first_name'],
            $patientInfo['last_name'],
            $patientInfo['second_name'],
            $patientInfo['birth_date'],
            $patientInfo['birth_country'],
            $patientInfo['birth_settlement'],
            $patientInfo['gender'],
            $patientInfo['email'],
            $this->contactsModelsProvider->getEhealthContactsModels($patientInfo['phones']),
            $this->addressModelsProvider->getPatientAddresses($patientInfo['addresses']),
        );
    }
}
