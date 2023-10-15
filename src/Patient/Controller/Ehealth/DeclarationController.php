<?php declare(strict_types=1);

namespace App\Patient\Controller\Ehealth;

use App\Patient\Service\DeclarationProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use OpenApi\Annotations as OA;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Patient\Model\Api\Declaration\DeclarationModel;
use Nelmio\ApiDocBundle\Annotation\Model;

class DeclarationController extends AbstractFOSRestController
{
    public function __construct(
        private DeclarationProvider $declarationProvider,
    ) {}

    /**
     * @Rest\Route("declaration/{uuid}", name="declaration.details.ehealth", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get declaration details"
     * )
     *
     * @OA\Parameter(
     *     name="uuid",
     *     in="path",
     *     description="Declaration uuid",
     *     example="c75f-45fb-badf-6e8d20b6a8a8"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns patient personal info",
     *     @Model(type=DeclarationModel::class)
     * )
     *
     *
     * @OA\Tag(name="ehealth")
     *
     * @Rest\View(statusCode=200)
     */
    public function getDeclarationDetailsAction(string $uuid): DeclarationModel
    {
        return $this->declarationProvider->getDeclarationById($uuid);
    }
}
