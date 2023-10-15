<?php declare(strict_types=1);

namespace App\Department\Controller\Api;

use App\Department\Model\Api\DepartmentModel;
use App\Department\Service\DepartmentsProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class DepartmentController extends AbstractFOSRestController
{
    public function __construct(
        private DepartmentsProvider $departmentsProvider,
    ) {}

    /**
     * @Rest\Route("departments", name="departments", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get departments"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns departments",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=DepartmentModel::class))
     *      )
     * )
     *
     * @OA\Tag(name="catalog")
     *
     * @Rest\View(statusCode=200)
     */
    public function getDepartments(): array
    {
        return $this->departmentsProvider->provideDepartmentsModels();
    }
}
