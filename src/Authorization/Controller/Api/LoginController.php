<?php declare(strict_types=1);

namespace App\Authorization\Controller\Api;

use App\Authorization\Exception\PatientUserNotAuthorizedException;
use App\PatientUser\Entity\PatientUser;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class LoginController extends AbstractFOSRestController
{
    /**
     * @Rest\Route("login", name="login", methods={"POST"})
     *
     * @OA\Post(
     *     summary="Login by email & password"
     * )
     *
     * @OA\RequestBody (
     *     @OA\JsonContent(
     *       @OA\Property(property="email", type="string", example="email@email.ua"),
     *       @OA\Property(property="password", type="string", example="strong_PASSword"),
     *     )
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Return when logged",
     *     @OA\JsonContent(
     *       @OA\Property(property="id", type="integer"),
     *     )
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
     * @OA\Tag(name="user_auth")
     *
     * @Rest\View(statusCode=200)
     */
    public function loginAction(Security $security): JsonResponse
    {
        $patientUser = $security->getUser();

        if ($patientUser instanceof PatientUser && $patientUser->isEnabled()) {
            return new JsonResponse(['id' => $patientUser->getId()],Response::HTTP_OK);
        }

        throw new PatientUserNotAuthorizedException();
    }

    /**
     * @Rest\Route("logout", name="logout", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Logout"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Return when logout"
     * )
     *
     * @OA\Tag(name="user_auth")
     *
     * @Rest\View(statusCode=200)
     */
    public function logoutAction(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }
}
