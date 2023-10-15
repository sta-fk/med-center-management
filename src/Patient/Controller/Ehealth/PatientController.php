<?php declare(strict_types=1);

namespace App\Patient\Controller\Ehealth;

use App\Patient\Api\PatientClient;
use App\Patient\Model\Api\Patient\PatientDetailsModel;
use App\Patient\Model\Api\Patient\PatientInfoModel;
use App\Patient\Service\Patient\PatientDetailsModelBuilder;
use App\Patient\Service\Patient\PatientInfoModelBuilder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PatientController extends AbstractFOSRestController
{
    public function __construct(
        private PatientClient $patientClient,
        private PatientInfoModelBuilder $patientInfoModelBuilder,
        private PatientDetailsModelBuilder $patientDetailsModelBuilder,
        private LoggerInterface $patientEhealthLogger,
    ) {}

    /**
     * @Rest\Route("info", name="patient.info.ehealth", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get patient personal info"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient personal info",
     *     @Model(type=PatientInfoModel::class)
     * )
     *
     * @OA\Tag(name="ehealth")
     *
     * @Rest\View(statusCode=200)
     */
    public function getPatientInfoAction(): PatientInfoModel
    {
        try {
            $patientInfo = $this->patientClient->getPatientInfo();

            return $this->patientInfoModelBuilder->getPatientInfoModel($patientInfo);
        } catch (\Throwable $e) {
            $this->patientEhealthLogger->error(__METHOD__.': '.$e->getMessage());

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @Rest\Route("details", name="patient.details.ehealth", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get patient person details"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient person details",
     *     @Model(type=PatientDetailsModel::class)
     * )
     *
     * @OA\Tag(name="ehealth")
     *
     * @Rest\View(statusCode=200)
     */
    public function getPatientDetailsAction(): PatientDetailsModel
    {
        try {
            $patientDetails = $this->patientClient->getPatientDetails();

            return $this->patientDetailsModelBuilder->getPatientInfoModel($patientDetails);
        } catch (\Throwable $e) {
            $this->patientEhealthLogger->error(__METHOD__.': '.$e->getMessage());

            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
