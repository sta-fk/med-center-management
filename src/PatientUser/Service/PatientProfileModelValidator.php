<?php declare(strict_types=1);

namespace App\PatientUser\Service;

use App\PatientUser\Exception\InvalidPatientProfileRequestException;
use App\PatientUser\Model\Api\Request\PatientProfileModel;
use FOS\RestBundle\Decoder\JsonDecoder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PatientProfileModelValidator
{
    public function __construct(
        private ValidatorInterface $validator,
        private LoggerInterface $patientUserApiLogger,
    ) {}

    /**
     * @throws InvalidPatientProfileRequestException
     */
    public function validate(PatientProfileModel $profileModel): void
    {
        $errors = $this->validator->validate($profileModel);

        $result = [];
        if (count($errors) > 0) {
            /** @var ConstraintViolation $error */
            foreach ($errors as $error) {
                $result[$error->getPropertyPath()] = $error->getMessage();
            }
        }

        if (count($result) > 0) {
            $this->patientUserApiLogger->critical(__METHOD__, $result);

            throw new InvalidPatientProfileRequestException(json_encode($result, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE));
        }
    }
}
