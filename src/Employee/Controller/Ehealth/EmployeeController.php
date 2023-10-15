<?php declare(strict_types=1);

namespace App\Employee\Controller\Ehealth;

use App\Employee\Api\EmployeeClient;
use App\Employee\Model\Ehealth\EmployeeShortModel;
use App\Employee\Model\Ehealth\EmployeeModel;
use App\Employee\Service\Ehealth\EmployeeShortModelBuilder;
use App\Employee\Service\Ehealth\EmployeeModelBuilder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EmployeeController extends AbstractFOSRestController
{
    public function __construct(
        private EmployeeClient $employeeClient,
        private EmployeeModelBuilder $employeeModelBuilder,
        private EmployeeShortModelBuilder $employeeShortModelBuilder,
        private LoggerInterface $employeeEhealthLogger,
    ) {}

    /**
     * @Rest\Route("employees", name="employee.list.ehealth", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get all employees info"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns all employees info",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=EmployeeShortModel::class))
     *     )
     * )
     *
     * @OA\Tag(name="ehealth")
     *
     * @Rest\View(statusCode=200)
     */
    public function getAllEmployeesAction(): array
    {
        try {
            return $this->employeeShortModelBuilder->getAllEmployeeModels(
                $this->employeeClient->getAllEmployees()
            );
        } catch (\Throwable $e) {
            $this->employeeEhealthLogger->error(__METHOD__, ['message' => $e->getMessage()]);

            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @Rest\Route("employees/{id}", name="employee.details.ehealth", methods={"GET"})
     *
     * @OA\Get(
     *     summary="Get employees details"
     * )
     *
     * @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Employee id",
     *     example="d290f1ee-6c54-4b01-90e6-d701748f0851"
     * )
     *
     * @OA\Response(
     *     response=200,
     *     description="Returns employees details",
     *     @Model(type=EmployeeModel::class)
     * )
     *
     * @OA\Tag(name="ehealth")
     *
     * @Rest\View(statusCode=200)
     */
    public function getEmployeeDetailsAction(string $id): EmployeeModel
    {
        try {
            return $this->employeeModelBuilder->buildEmployeeModel(
                $this->employeeClient->getEmployeeDetailsById($id)
            );
        } catch (\Throwable $e) {
            $this->employeeEhealthLogger->error(__METHOD__, ['message' => $e->getMessage()]);

            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
