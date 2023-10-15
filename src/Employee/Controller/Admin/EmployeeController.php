<?php

namespace App\Employee\Controller\Admin;

use App\Employee\Repository\EmployeeRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class EmployeeController extends AbstractFOSRestController
{
    public function __construct(
        private EmployeeRepository $employeeRepository,
    ) {}
    /**
     * @Rest\Route("employees", name="admin.employees", methods={"GET"})
     *
     * @Rest\View(statusCode=200)
     */
    public function getEmployeesAction(): array
    {
        return [];
    }
}
