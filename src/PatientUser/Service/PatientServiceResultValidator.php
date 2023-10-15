<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\Appointments\Exception\ServiceNotFoundException;
use App\Appointments\Repository\AppointmentsRepository;
use App\Authorization\Exception\FailedRegisterUserException;
use App\Authorization\Exception\InvalidPatientUserModelException;
use App\Catalog\Exception\ServiceResultNotFoundException;
use App\Catalog\Repository\ServiceRepository;
use App\Catalog\Repository\ServiceResultRepository;
use App\PatientUser\Exception\InvalidPatientServiceResultRequestException;
use App\PatientUser\Model\Api\Request\PatientServiceResultModel;
use App\PatientUser\Model\Api\Request\PatientUserModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatientServiceResultValidator
{
    public function __construct(
        private ValidatorInterface $validator,
        private LoggerInterface $patientUserApiLogger,
        private ServiceRepository $serviceRepository,
        private ServiceResultRepository $serviceResultRepository,
        private AppointmentsRepository $appointmentsRepository,
    ) {}

    public function validatePatientServiceResultModel(PatientServiceResultModel $resultModel): void
    {
        $errors = $this->validator->validate($resultModel);

        $result = [];
        $this->serviceRepository->findOneBy(['id' => $resultModel->getServiceId()])
            ?? $result['service'] = 'Service with id ' . $resultModel->getServiceId() . ' not found';

        $resultTemplate = $this->serviceResultRepository->findOneBy(['service' => $resultModel->getServiceId()]);

        $resultTemplate
            ?? $result['template'] = 'Result template for service with id ' . $resultModel->getServiceId() . ' not found';

        if ($resultModel->getAppointmentId()) {
            $appointment = $this->appointmentsRepository->findOneBy(['id' => $resultModel->getAppointmentId()]);

            $appointment
                ?? $result['appointment'] = 'Appointment not found by id ' . $resultModel->getAppointmentId();

            if ($appointment[0]->getService()->getId() !== $resultModel->getServiceId()) {
                $result['appointmentService'] = 'Appointment service not equal to request service';
            }
        }

        if (
            $resultTemplate
            && count($resultTemplate->getTemplate()) !== count($resultModel->getResult())
        ) {
                $result['requestResult'] = 'Request result not equal to template' ;
        }

        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $result[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        if (count($result) > 0) {
            $this->patientUserApiLogger->critical(__METHOD__, $result);

            throw new InvalidPatientServiceResultRequestException(json_encode($result, JSON_UNESCAPED_UNICODE));
        }
    }
}
