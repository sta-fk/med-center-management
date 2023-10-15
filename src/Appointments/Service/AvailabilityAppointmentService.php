<?php declare(strict_types=1);

namespace App\Appointments\Service;

use App\Appointments\Exception\AppointmentIsUnavailableException;
use App\Appointments\Exception\NotWorkingHoursException;
use App\Appointments\Exception\ServiceNotFoundException;
use App\Appointments\Repository\AppointmentsRepository;
use App\Catalog\Entity\Service;
use App\Employee\Entity\Employee;

class AvailabilityAppointmentService
{
    public function __construct(
        private AppointmentsRepository $appointmentsRepository,
    ) {}

    public function checkAvailability(Employee $requestEmployee, Service $requestService, \DateTimeImmutable $requestAppointmentStartAt, bool $availableExceptions): bool
    {
        $start = $requestEmployee->getStartWorkHours()->setDate(
            (int)$requestAppointmentStartAt->format('Y'),
            (int)$requestAppointmentStartAt->format('m'),
            (int)$requestAppointmentStartAt->format('d')
        );
        $end = $requestEmployee->getEndWorkHours()->setDate(
            (int)$requestAppointmentStartAt->format('Y'),
            (int)$requestAppointmentStartAt->format('m'),
            (int)$requestAppointmentStartAt->format('d')
        );

        if (!($start <= $requestAppointmentStartAt && $requestAppointmentStartAt <= $end)) {
            $availableExceptions ?? throw new NotWorkingHoursException('Request hours are unavailable for employee with id ' . $requestEmployee->getId());

            return false;
        }

        $requestServiceDuration = $requestService->getDuration() ?? throw new ServiceNotFoundException();
        $requestAppointmentEndAt = $requestAppointmentStartAt->add(new \DateInterval(sprintf('PT%sH%sM', $requestServiceDuration->format('H'), $requestServiceDuration->format('i'))));
        if ($requestAppointmentEndAt >= $end) {
            $availableExceptions ?? throw new NotWorkingHoursException('Request hours are unavailable for employee with id ' . $requestEmployee->getId());

            return false;
        }

        $appointmentsOnDay = $this->appointmentsRepository->getAppointmentsOnDayForEmployee($requestEmployee->getId(), $requestAppointmentStartAt);

        return $this->checkAvailabilityBySchedule(
            $appointmentsOnDay,
            $requestAppointmentStartAt,
            $requestAppointmentEndAt,
            $availableExceptions
        );
    }

    public function checkAvailabilityBySchedule(array $appointmentsOnDay, \DateTimeImmutable $requestAppointmentStartAt, \DateTimeImmutable $requestAppointmentEndAt, bool $availableExceptions): bool
    {
        $schedule = array_map(
            function ($appointment) {
                $duration = $appointment['duration'];

                return [
                    'startAt' => $appointment['time'],
                    'endAt' => $appointment['time']->add(new \DateInterval(sprintf('PT%sH%sM', $duration->format('H'), $duration->format('i')))),
                ];
            }, $appointmentsOnDay
        );

        foreach ($schedule as $key => $unavailable) {
            if (
                ($unavailable['startAt'] <= $requestAppointmentStartAt && $unavailable['endAt'] >= $requestAppointmentStartAt)
                || ($unavailable['startAt'] <= $requestAppointmentEndAt && $unavailable['endAt'] >= $requestAppointmentEndAt)
                || ($unavailable['startAt'] >= $requestAppointmentStartAt && $unavailable['endAt'] <= $requestAppointmentEndAt)
            ) {
                $availableExceptions && throw new AppointmentIsUnavailableException();

                return false;
            }
        }

        return true;
    }
}
