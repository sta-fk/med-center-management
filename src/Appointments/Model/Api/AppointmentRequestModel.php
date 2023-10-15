<?php declare(strict_types=1);

namespace App\Appointments\Model\Api;

use App\Api\Request\ModelArgumentValueInterface;
use JMS\Serializer\Annotation as JMS;

class AppointmentRequestModel implements ModelArgumentValueInterface
{
    public function __construct(
        private int $employeeId,
        private int $serviceId,

        /**
         * @JMS\Type("DateTimeImmutable<'Y-m-d\TH:i:s'>")
         */
        private \DateTimeImmutable $time,
    ) {}

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getTime(): \DateTimeImmutable
    {
        return $this->time;
    }
}
