<?php declare(strict_types=1);

namespace App\Patient\Service;

use App\Patient\Api\DeclarationClient;
use App\Patient\Api\PatientClient;
use App\Patient\Exception\DeclarationNotFoundInEhealthException;
use App\Patient\Model\Api\Declaration\DeclarationModel;
use App\Patient\Service\Declaration\DeclarationModelBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DeclarationProvider
{
    public function __construct(
        private PatientClient $patientClient,
        private DeclarationClient $declarationClient,
        private LoggerInterface $patientEhealthLogger,
        private LoggerInterface $declarationApiLogger,
        private DeclarationModelBuilder $declarationModelBuilder,
    ) {}

    public function getDeclarationIdByPatientId(string $id)
    {
        try {
            $declaration = $this->patientClient->getPatientDeclarationById($id);;
        } catch (\Throwable $e) {
            $this->patientEhealthLogger->error(__METHOD__ . ': ' . $e->getMessage());

            throw new DeclarationNotFoundInEhealthException('Declaration for patient with id '. $id .' not found in Ehealth');
        }

        return array_key_exists(0, $declaration)
            ? $declaration[0]['id']
            : throw new DeclarationNotFoundInEhealthException('Declaration for patient with id '. $id .' not found in Ehealth')
        ;
    }

    public function getDeclarationById(string $id): DeclarationModel
    {
        try {
            $declaration = $this->declarationClient->getDeclarationById($id);

            return $this->declarationModelBuilder->getDeclarationModel($declaration);
        } catch (\Throwable $e) {
            $this->declarationApiLogger->error(__METHOD__.': '.$e->getMessage());

            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
