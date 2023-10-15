<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Response;

use JMS\Serializer\Annotation as JMS;

class PatientAppointmentModel
{
    public function __construct(
        private int $serviceId,
        private int $patientId,
        private int $employeeId,
        private string $serviceName,
        private float $servicePrice,
        private string $employeeName,
        private string $employeeSlug,
        private string $departmentSlug,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d\TH:i:s'>")
         */
        private \DateTimeImmutable $startAt,

        /**
         * @JMS\Type("DateTimeImmutable<'H:i'>")
         */
        private \DateTimeImmutable $duration,
    ) {}
}
