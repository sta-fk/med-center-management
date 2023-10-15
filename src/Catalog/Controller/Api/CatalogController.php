<?php declare(strict_types=1);

namespace App\Catalog\Controller\Api;

use App\Catalog\Model\Api\PriceListContentModel;
use App\Catalog\Model\Api\DepartmentServicesModel;
use App\Catalog\Model\Api\DepartmentServicesPaginationModel;
use App\Catalog\Model\Api\ServiceGroupModel;
use App\Catalog\Model\Api\ServiceModel;
use App\Catalog\Service\DepartmentServicesPaginationModelBuilder;
use App\Catalog\Service\DepartmentServicesProvider;
use App\Catalog\Service\PriceListProvider;
use App\Catalog\Service\ServicesProvider;
use App\Pagination\Model\AbstractPaginationModel;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;

class CatalogController extends AbstractFOSRestController
{
    public function __construct(
        private ServicesProvider $servicesProvider,
        private LoggerInterface $catalogApiLogger,
        private DepartmentServicesProvider $departmentServicesProvider,
        private PaginatorInterface $paginator,
        private DepartmentServicesPaginationModelBuilder $departmentServicesPaginationModelBuilder,
        private PriceListProvider $priceListProvider,
    ) {}

    /**
     * @Rest\Route("price-list", name="price_list", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get services of all departments for pricelist"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns services for pricelist",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref=@Model(type=PriceListContentModel::class))
     *      )
     * )
     *
     * @OA\Tag(name="catalog")
     *
     * @Rest\View(statusCode=200)
     */
    public function getCatalogAction(): array
    {
        return $this->priceListProvider->getPriceList()->getServices()->getValues();
    }

    /**
     * @Rest\Route("departments/services", name="all_services_in_departments", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get services of all departments"
     * )
     *
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="Number page",
     *     example="2"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns services of all departments",
     *     @OA\JsonContent(
     *      oneOf={
     *          @OA\Schema(
     *              ref=@Model(type=DepartmentServicesPaginationModel::class)
     *          ),
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(ref=@Model(type=DepartmentServicesModel::class))
     *          ),
     *      })
     * )
     *
     * @OA\Tag(name="catalog")
     *
     * @Rest\View(statusCode=200)
     */
    public function getDepartmentsServicesAction(Request $request): array|AbstractPaginationModel
    {
        $departments = $this->departmentServicesProvider->getDepartmentServicesExcludeWithoutDetails();

        if ($request->get('page')) {
            $pagination = $this->paginator->paginate(
                $departments->getServices()->getValues(),
                (int)$request->get('page'),
                $request->get('limit') ? (int)$request->get('limit') : 5
            );

            return $this->departmentServicesPaginationModelBuilder->buildPaginationModel($pagination);
        }

        return $departments->getServices()->getValues();
    }

    /**
     * @Rest\Route("department/{id}/services", name="services_by_department", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get services by department id"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Department id",
     *     example="3"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns services",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ServiceModel::class))
     *     )
     * )
     *
     * @OA\Tag(name="catalog")
     *
     * @Rest\View(statusCode=200)
     */
    public function getServicesByDepartmentIdAction(int $id): array
    {
        return $this->servicesProvider->getServicesByDepartmentId($id);
    }

    /**
     * @Rest\Route("researches", name="researches", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get service researches"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns service researches",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=ServiceGroupModel::class)),
     *        example={
     *                  {
     *                      "id": 0,
     *                      "name": "Research category",
     *                      "slug": "research-category-slug",
     *                      "items": {
     *                                  {
     *                                      "id": 0,
     *                                      "name": "Research item",
     *                                      "slug": "research-item-slug",
     *                                      "code": 101,
     *                                      "price": 101.00,
     *                                      "details": null,
     *                                  }
     *                              }
     *                  }
     *              }
     *     )
     * )
     *
     * @OA\Tag(name="catalog")
     *
     * @Rest\View(statusCode=200)
     */
    public function getResearchesAction(): array
    {
        return $this->servicesProvider->getResearchModels();
    }
}
