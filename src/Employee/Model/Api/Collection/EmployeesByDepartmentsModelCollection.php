<?php declare(strict_types=1);

namespace App\Employee\Model\Api\Collection;

use App\Employee\Model\Api\EmployeesByDepartmentsModel;
use Doctrine\Common\Collections\ArrayCollection;

class EmployeesByDepartmentsModelCollection
{
    /**
     * @var EmployeesByDepartmentsModel[]|ArrayCollection
     */
    private ArrayCollection|array $departments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
    }

    public function addEmployeesByDepartments(EmployeesByDepartmentsModel $employeeModel): void
    {
        if (!$this->departments->contains($employeeModel)) {
            $this->departments->add($employeeModel);
        }
    }

    public function getEmployeesByDepartments(): ArrayCollection|array
    {
        return $this->departments;
    }
}
