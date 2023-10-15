<?php declare(strict_types=1);

namespace App\Search\Controller\Api;

use App\Catalog\Repository\ServiceRepository;
use App\Employee\Repository\EmployeeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractFOSRestController
{
    public function __construct(
        private ServiceRepository $serviceRepository,
        private EmployeeRepository $employeeRepository,
    ) {}

    /**
     * @Rest\Route("/services", name="search.services", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get services name, price and details by part name"
     * )
     *
     * @OA\Parameter(
     *     name="serviceName",
     *     in="query",
     *     description="Service name starts with",
     *     example="Прогр"
     * )
     *
     * @OA\Parameter(
     *     name="departmentId",
     *     in="query",
     *     description="Department id",
     *     example="4"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns services name, price and details",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(
     *              type="object",
     *              example={
     *                  "name": "Гастроскопія",
     *                  "price": 100,
     *                  "details": null
     *              })
     *     )
     * )
     *
     * @OA\Tag(name="search")
     *
     * @Rest\View(statusCode=200)
     */
    public function searchServiceAction(Request $request): array
    {
        if ($request->get('serviceName') && !empty($request->get('serviceName'))) {
            return $this->serviceRepository->searchServicesByName(
                $request->get('serviceName'),
                (int)$request->get('departmentId')
            );
        }

        return [];
    }

    /**
     * @Rest\Route("/employees", name="search.specialists", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get employees name, brief, slugs for url"
     * )
     *
     * @OA\Parameter(
     *     name="employeeName",
     *     in="query",
     *     description="Employee fullname starts with",
     *     example="Світ"
     * )
     *
     * @OA\Parameter(
     *     name="departmentId",
     *     in="query",
     *     description="Department id",
     *     example="3"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns employees name, brief, slugs for url",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(
     *              type="object",
     *              example={
     *                  "employeeId": 1,
     *                  "departmentId": 1,
     *                  "firstName": "Світлана",
     *                  "lastName": "Сивожелізова",
     *                  "brief": "Акушер-гінеколог",
     *                  "departmentName": "Гінекологія",
     *                  "departmentSlug": "gastroenterology",
     *                  "employeeSlug": "syvozhelizova-svitlana-viktorivna"
     *              })
     *     )
     * )
     *
     * @OA\Tag(name="search")
     *
     * @Rest\View(statusCode=200)
     */
    public function searchSpecialistsAction(Request $request): array
    {
        if ($request->get('employeeName')) {
            return $this->employeeRepository->searchEmployeesByName(
                $request->get('employeeName'),
                (int)$request->get('departmentId')
            );
        }

        return [];
    }
}
