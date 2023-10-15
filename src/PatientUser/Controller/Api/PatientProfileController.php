<?php declare(strict_types=1);

namespace App\PatientUser\Controller\Api;

use App\Authorization\Exception\PatientUserNotAuthorizedException;
use App\Authorization\Exception\PatientUserNotFoundException;
use App\Patient\Exception\PatientNotFoundInEhealthException;
use App\Patient\Model\Api\Declaration\DeclarationModel;
use App\Patient\Service\DeclarationProvider;
use App\PatientUser\Entity\PatientUser;
use App\PatientUser\Model\Api\Request\PatientProfileModel as CreateProfileModel;
use App\PatientUser\Model\Api\Response\PatientAppointmentModel;
use App\PatientUser\Model\Api\Response\PatientAppointmentsCountModel;
use App\PatientUser\Model\Api\Response\PatientProfileModel as ProfileModel;
use App\PatientUser\Repository\PatientProfileRepository;
use App\PatientUser\Manager\PatientProfileManager;
use App\PatientUser\Service\PatientAppointmentModelsProvider;
use App\PatientUser\Service\PatientProfileModelBuilder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class PatientProfileController extends AbstractFOSRestController
{
    public function __construct(
        private PatientProfileRepository $patientProfileRepository,
        private PatientProfileModelBuilder $profileModelBuilder,
        private PatientProfileManager $profileManager,
        private DeclarationProvider $declarationProvider,
        private PatientAppointmentModelsProvider $appointmentModelsProvider,
    ) {}

    /**
     * @Rest\Route("/exists", name="patient.profile_exists", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @OA\Get(
     *     summary="Does patient user have profile"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns true if profile exists and false if not",
     * )
     *
     * @OA\Response(
     *     response=401,
     *     description="Return when error",
     *     @OA\JsonContent(
     *       @OA\Property(property="error", type="string", example="Invalid credentials."),
     *     )
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function isExistsUserProfile(Security $security): JsonResponse
    {
        $patientUser = $security->getUser();

        if ($patientUser instanceof PatientUser && $patientUser->isEnabled()) {
            return $patientUser->getProfile()
                ? new JsonResponse(true,Response::HTTP_OK)
                : new JsonResponse(false,Response::HTTP_OK);
        }

        throw new PatientUserNotAuthorizedException();
    }

    /**
     * @Rest\Route("/{id}", name="patient.profile", methods={"GET"}, requirements={"id"="\d+"})
     *
     * @OA\Get(
     *     summary="Get patient person details"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient person details",
     *     @Model(type=ProfileModel::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Required user not found"
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function getPatientProfileById(int $id): ProfileModel
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        return $this->profileModelBuilder->buildPatientProfileModel($profile);
    }

    /**
     * @Rest\Route("/{id}/declaration", name="patient.profile.declaration", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get patient declaration"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient declaration",
     *     @Model(type=DeclarationModel::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Required user not found"
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function getDeclarationByPatientId(int $id): DeclarationModel
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                'Impossible to find declaration without personal info. Create profile to solve this problem'
            );
        }

        if ($profile->isPatientInEhealth()) {
            return $this->declarationProvider->getDeclarationById($profile->getPatientEhealthInfo()->getDeclarationId());
        }

        throw new PatientNotFoundInEhealthException();
    }

    /**
     * @Rest\Route("/{id}", name="patient.create_profile", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Create patient profile"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=CreateProfileModel::class)
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="Patient profile was created",
     * )
     *
     * @OA\Response(
     *     response=409,
     *     description="Patient profile already exists",
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=201)
     */
    public function createPatientProfileById(CreateProfileModel $profileModel, int $id)
    {
        $this->profileManager->create($profileModel, $id);
    }

    /**
     * @Rest\Route("/{id}/appointments", name="patient.appointments", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get patient appointments"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient appointments",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=PatientAppointmentModel::class))
     *      )
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Required user not found"
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function getPatientAppointmentsById(int $id): array
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        return $this->appointmentModelsProvider->getPatientAppointments($profile->getId());
    }

    /**
     * @Rest\Route("/{id}/appointments/count", name="patient.appointments.count", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get patient appointments count"
     * )
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Patient user id"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient appointments count",
     *     @Model(type=PatientAppointmentsCountModel::class)
     * )
     *
     * @OA\Response(
     *     response=404,
     *     description="Required user not found"
     * )
     *
     * @OA\Tag(name="patient")
     *
     * @Rest\View(statusCode=200)
     */
    public function getPatientAppointmentsCountById(int $id): PatientAppointmentsCountModel
    {
        $profile = $this->patientProfileRepository->findOneBy(['user' => $id]);

        if (is_null($profile)) {
            throw new PatientUserNotFoundException(
                sprintf('Required profile user with id %s not found', $id)
            );
        }

        return $this->appointmentModelsProvider->getPatientAppointmentsCount($profile->getId());
    }
}
