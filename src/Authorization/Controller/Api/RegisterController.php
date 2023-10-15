<?php declare(strict_types=1);

namespace App\Authorization\Controller\Api;

use App\Authorization\Service\PatientUserRegistrationService;
use App\PatientUser\Model\Api\Request\PatientUserModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractFOSRestController
{
    public function __construct(
        private PatientUserRegistrationService $registrationService,
    ) {}

    /**
     * @Rest\Route("register", name="register", methods={"POST"})
     *
     * @OA\Post(
     *     summary="User registration by email"
     * )
     *
     * @OA\RequestBody(
     *     @Model(type=PatientUserModel::class)
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="User registration is success"
     * )
     *
     * @OA\Response(
     *     response=400,
     *     description="User request data is invalid",
     *     @OA\JsonContent(
     *       @OA\Property(property="code", type="integer"),
     *       @OA\Property(property="message", type="string"),
     *     )
     * )
     *
     * @OA\Response(
     *     response=422,
     *     description="User request exists",
     *     @OA\JsonContent(
     *       @OA\Property(property="code", type="integer"),
     *       @OA\Property(property="message", type="string"),
     *     )
     * )
     *
     * @OA\Tag(name="user_auth")
     *
     * @Rest\View(statusCode=200)
     */
    public function register(PatientUserModel $patientUserModel): void
    {
        $this->registrationService->registerUser($patientUserModel);
    }

    /**
     * @Rest\Route("confirm/{code}", name="email_confirmation", methods={"GET"})
     *
     * @OA\Patch(
     *     summary="User email confirmation"
     * )
     *
     * @OA\Parameter(
     *     name="code",
     *     in="path",
     *     description="Confirmation code from email on registration"
     * )
     *
     * @OA\Response(
     *     response=201,
     *     description="User account is confirmed"
     * )
     * @OA\Response(
     *     response=404,
     *     description="User not found",
     *     @OA\JsonContent(
     *       @OA\Property(property="code", type="integer"),
     *       @OA\Property(property="message", type="string"),
     *     )
     * )
     *
     * @OA\Tag(name="user_auth")
     *
     * @Rest\View(statusCode=201)
     */
    public function confirmEmail(Request $request, string $code): RedirectResponse
    {
        $this->registrationService->confirmEmail($code);

        return new RedirectResponse(sprintf('%s://%s/%s',
            $request->getScheme(),
            $request->getHttpHost(),
            'success-signup')
        );
    }
}
