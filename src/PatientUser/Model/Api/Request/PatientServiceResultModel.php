<?php declare(strict_types=1);

namespace App\PatientUser\Model\Api\Request;

use App\Api\Request\ModelArgumentValueInterface;
use App\Catalog\Model\Api\ServiceResultTemplateModel;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

class PatientServiceResultModel implements ModelArgumentValueInterface
{
    public function __construct(

        /**
         * @Assert\NotBlank()
         */
        private int $serviceId,

        private ?int $appointmentId,

        /**
         * @JMS\Type("array")
         */
        private array $result,
    ) {}

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function getAppointmentId(): ?int
    {
        return $this->appointmentId;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
