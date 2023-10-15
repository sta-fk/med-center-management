<?php declare(strict_types=1);

namespace App\Employee\Controller\Api;

use App\Employee\Model\Api\EmployeesByDepartmentsModel;
use App\Employee\Model\Api\EmployeeModel;
use App\Employee\Model\Api\EmployeeShortModel;
use App\Employee\Repository\EmployeeRepository;
use App\Employee\Service\EmployeeModelBuilder;
use App\Employee\Service\EmployeesByDepartmentsProvider;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;

class EmployeeController extends AbstractFOSRestController
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
        private EmployeeModelBuilder $employeeModelBuilder,
        private EmployeesByDepartmentsProvider $employeesByDepartmentsProvider,
    ) {}

    /**
     * @Rest\Route("employees/{id}", name="employee.details", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get employee info by id"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Employee id",
     *     example="11"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns employee info",
     *     @Model(type=EmployeeModel::class)
     * )
     *
     * @OA\Tag(name="employee")
     *
     * @Rest\View(statusCode=200)
     */
    public function getEmployeeByIdAction(int $id): EmployeeModel
    {
        return $this->employeeModelBuilder->buildEmployeeModel(
            $this->employeeRepository->findOneBy(['id' => $id])
        );
    }

    /**
     * @Rest\Route("employees", name="employee.list", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get departments with all employees"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns all employees by departments",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=EmployeesByDepartmentsModel::class))
     *     )
     * )
     *
     * @OA\Tag(name="employee")
     *
     * @Rest\View(statusCode=200)
     */
    public function getAllEmployeesAction(): array
    {
        return $this->employeesByDepartmentsProvider->getAllEmployeesByDepartments()->getEmployeesByDepartments()->getValues();
    }

    /**
     * @Rest\Route("department/{id}/employees", name="employees_by_department", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get employees by department id"
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
     *     description="Returns all employees by department id",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=EmployeeShortModel::class))
     *     )
     * )
     *
     * @OA\Tag(name="employee")
     *
     * @Rest\View(statusCode=200)
     */
    public function getEmployeesByDepartmentAction(int $id): array
    {
        return $this->employeesByDepartmentsProvider->getAllEmployeesByDepartmentId($id);
    }
}
