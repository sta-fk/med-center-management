<?php declare(strict_types=1);

namespace App\Appointments\Service;

use App\Appointments\Exception\EmployeeNotReferToRequireServiceException;
use App\Appointments\Exception\InvalidParametersException;
use App\Appointments\Exception\ServiceIsResearchException;
use App\Authorization\Exception\PatientUserNotFoundException;
use App\Catalog\Entity\Service;
use App\Employee\Entity\Employee;
use App\PatientUser\Entity\PatientProfile;

class AppointmentCommonValidator
{
    public function validate(?PatientProfile $user, ?Service $service, ?Employee $employee, \DateTimeImmutable $date): void
    {
        if (is_null($user)) {
            throw new PatientUserNotFoundException();
        }

        if ($date <= new \DateTimeImmutable('now')) {
            throw new InvalidParametersException('Date is passed');
        }

        if (is_null($employee) || is_null($service)) {
            throw new InvalidParametersException('Parameters are invalid');
        }

        if ($service->isResearch()) {
            throw new ServiceIsResearchException();
        }

        if ($employee->getDepartment()->getId() !== $service->getDepartment()->getId()) {
            throw new EmployeeNotReferToRequireServiceException();
        }
    }
}
