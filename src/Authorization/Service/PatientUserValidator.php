<?php declare(strict_types=1);

namespace App\Authorization\Service;

use App\Authorization\Exception\FailedRegisterUserException;
use App\Authorization\Exception\InvalidPatientUserModelException;
use App\PatientUser\Entity\PatientUser;
use App\PatientUser\Model\Api\Request\PatientUserModel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatientUserValidator
{
    public function __construct(
        private ValidatorInterface $validator,
        private LoggerInterface $patientUserApiLogger,
    ) {}

    public function validatePatientUser(PatientUserModel|PatientUser $patientUser): void
    {
        $errors = $this->validator->validate($patientUser);

        $result = [];
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $result[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        if (count($result) > 0) {
            $this->patientUserApiLogger->critical(__METHOD__, $result);

            $patientUser instanceof PatientUserModel
                ? throw new InvalidPatientUserModelException(json_encode($result, JSON_UNESCAPED_UNICODE))
                : throw new FailedRegisterUserException(json_encode($result, JSON_UNESCAPED_UNICODE))
            ;
        }
    }
}
