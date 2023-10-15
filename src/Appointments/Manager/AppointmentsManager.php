<?php declare(strict_types=1);

namespace App\Appointments\Manager;

use App\Appointments\Entity\Appointments;
use App\Appointments\Exception\ServiceNotFoundException;
use App\Appointments\Model\Api\AppointmentRequestModel;
use App\Appointments\Repository\AppointmentsRepository;
use App\Appointments\Service\AppointmentCommonValidator;
use App\Appointments\Service\AvailabilityAppointmentService;
use App\Catalog\Repository\ServiceRepository;
use App\Employee\Repository\EmployeeRepository;
use App\PatientUser\Repository\PatientProfileRepository;

class AppointmentsManager
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private PatientProfileRepository $profileRepository,
        private AppointmentsRepository $appointmentsRepository,
        private ServiceRepository $serviceRepository,
        private AppointmentCommonValidator $validator,
        private AvailabilityAppointmentService $availabilityAppointmentService,
    ) {}

    public function createAppointment(int $userId, AppointmentRequestModel $requestAppointment): void
    {
        $this->validator->validate(
            $requestPatient = $this->profileRepository->findOneBy(['user' => $userId]),
            $requestService = $this->serviceRepository->findOneBy(['id' => $requestAppointment->getServiceId()]),
            $requestEmployee = $this->employeeRepository->findOneBy(['id' => $requestAppointment->getEmployeeId()]),
            $requestAppointmentStartAt = $requestAppointment->getTime()
        );

        $patientAppointmentsOnDay = $this->appointmentsRepository->getAppointmentsOnDayForPatient($requestPatient->getId(), $requestAppointmentStartAt);
        $requestServiceDuration = $requestService->getDuration() ?? throw new ServiceNotFoundException();
        $requestAppointmentEndAt = $requestAppointmentStartAt->add(new \DateInterval(
            sprintf(
                'PT%sH%sM',
                $requestServiceDuration->format('H'),
                $requestServiceDuration->format('i')
            )
        ));

        $this->availabilityAppointmentService->checkAvailabilityBySchedule(
            $patientAppointmentsOnDay,
            $requestAppointmentStartAt,
            $requestAppointmentEndAt,
            true
        );
        $this->availabilityAppointmentService->checkAvailability($requestEmployee, $requestService, $requestAppointmentStartAt, true);

        $appointment = new Appointments();
        $appointment->setTime($requestAppointment->getTime());
        $appointment->addEmployee($requestEmployee);
        $appointment->addService($requestService);
        $appointment->addPatient($requestPatient);

        $this->appointmentsRepository->add($appointment, true);
    }

    public function getAvailableAppointmentsTime(int $userId, int $serviceId, int $employeeId, string $date): array
    {
        $this->validator->validate(
            $this->profileRepository->findOneBy(['user' => $userId]),
            $requestService = $this->serviceRepository->findOneBy(['id' => $serviceId]),
            $requestEmployee = $this->employeeRepository->findOneBy(['id' => $employeeId]),
            $requestDay = new \DateTimeImmutable($date),
        );
        $start = $requestEmployee->getStartWorkHours()->setDate((int)$requestDay->format('Y'), (int)$requestDay->format('m'), (int)$requestDay->format('d'),);
        $end = $requestEmployee->getEndWorkHours()->setDate((int)$requestDay->format('Y'), (int)$requestDay->format('m'), (int)$requestDay->format('d'),);

        $requestServiceDuration = $requestService->getDuration() ?? throw new ServiceNotFoundException();

        $availableTime = [];
        while ($start < $end) {
            $availableTime[] = $start;
            $hours = (int)$requestServiceDuration->format('H');
            $minutes = (int)$requestServiceDuration->format('i');
            $formatDuration = sprintf('+ %s %s', (0 !== $hours ? $hours . ' hours ' : ''), (0 !== $minutes ? $minutes . ' minutes' : ''));
            $start = $start->modify($formatDuration);
        }
        $availableTime[] = $start;

        return array_values(array_filter(
            $availableTime,
            function ($timeStartAt) use ($requestEmployee, $requestService) {
                return $this->availabilityAppointmentService->checkAvailability($requestEmployee, $requestService, $timeStartAt, false);
            }
        ));
    }
}
