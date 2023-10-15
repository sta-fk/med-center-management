<?php declare(strict_types=1);

namespace App\PatientUser\Controller\Api;

use App\PatientUser\Manager\PatientServiceResultManager;
use App\Authorization\Exception\PatientUserNotFoundException;
use App\PatientUser\Model\Api\Request\PatientServiceResultModel as PatientServiceResultRequest;
use App\PatientUser\Model\Api\Response\PatientServiceResultModel as PatientServiceResultResponse;
use App\PatientUser\Repository\PatientProfileRepository;
use App\PatientUser\Service\PatientServiceResultService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class PatientServiceResultController extends AbstractFOSRestController
{
    public function __construct(
        private PatientProfileRepository $patientProfileRepository,
        private PatientServiceResultManager $patientServiceResultManager,
        private PatientServiceResultService $patientServiceResultService,
    ) {}

    /**
     * @Rest\Route("/{id}/service/result", name="patient.create_service_result", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Create patient service result"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=PatientServiceResultRequest::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Service result was created",
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=201)
     */
    public function createServiceResultAction(int $id, PatientServiceResultRequest $resultModel)
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        $this->patientServiceResultManager->create($profile, $resultModel);
    }

    /**
     * @Rest\Route("/{id}/service/results", name="patient.service_results", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get service results by patient user id"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns available results",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=PatientServiceResultResponse::class))
     *      )
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function getServiceResultsAction(int $id): array
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        return $this->patientServiceResultService->getPatientServiceResults($profile);
    }

    /**
     * @Rest\Route("/{id}/{serviceSlug}/{date}", name="patient.service_results_pdf", methods={"GET"}, requirements={"date"="\d{2}-\d{2}-\d{4}"})
     *
     * @OA\Get(
     *     summary="Get service result pdf"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Parameter(
     *     name="serviceSlug",
     *     in="path",
     *     description="Service slug"
     * )
     *
     * @OA\Parameter(
     *     name="date",
     *     in="path",
     *     description="Date format d-m-Y"
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Returns result pdf"
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=201)
     */
    public function getServiceResultPdfAction(int $id, string $serviceSlug, string $date)
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        $this->patientServiceResultService->getPatientServiceResultPdf($profile, $serviceSlug, $date);
    }
}
