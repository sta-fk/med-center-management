<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\Employee\Repository\EmployeeInfoRepository;
use App\PatientUser\Model\Api\Response\PatientAppointmentModel;
use App\PatientUser\Model\Api\Response\PatientAppointmentsCountModel;
use App\PatientUser\Repository\PatientProfileRepository;

class PatientAppointmentModelsProvider
{
    public function __construct(
        private PatientProfileRepository $profileRepository,
        private EmployeeInfoRepository $employeeInfoRepository,
    ) {}

    public function getPatientAppointmentsCount(int $id): PatientAppointmentsCountModel
    {
        return new PatientAppointmentsCountModel(
            $this->profileRepository->getPatientPastAppointmentsCount($id),
            $this->profileRepository->getPatientUpcomingAppointmentsCount($id),
        );
    }

    /**
     * @return PatientAppointmentModel[]
     */
    public function getPatientAppointments(int $id): array
    {
        $appointments = $this->profileRepository->getPatientAppointments($id);

        return $this->buildPatientAppointmentModels($appointments);
    }

    /**
     * @return PatientAppointmentModel[]
     */
    public function buildPatientAppointmentModels(array $appointments): array
    {
        return array_map(
            function ($appointment) {
                $employeeInfo = $this->employeeInfoRepository->getEmployeeInfoForAppointment($appointment['employeeId']);

                return new PatientAppointmentModel(
                    $appointment['id'],
                    $appointment['patientId'],
                    $appointment['employeeId'],
                    $appointment['serviceName'],
                    (float)$appointment['servicePrice'],
                    sprintf('%s %s', $employeeInfo['firstName'], $employeeInfo['lastName']),
                    $employeeInfo['employeeSlug'],
                    $employeeInfo['departmentSlug'],
                    $appointment['time'],
                    $appointment['serviceDuration'],
                );
            }, $appointments
        );
    }
}
