<?php declare(strict_types=1);

namespace App\Employee\Model\Api\Collection;

use App\Employee\Model\Api\EmployeeShortModel;
use Doctrine\Common\Collections\ArrayCollection;

class EmployeeForListModelCollection
{
    /**
     * @var EmployeeShortModel[]|ArrayCollection
     */
    private ArrayCollection|array $employees;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public function addEmployee(EmployeeShortModel $employeeModel): void
    {
        if (!$this->employees->contains($employeeModel)) {
            $this->employees->add($employeeModel);
        }
    }

    public function getEmployees(): ArrayCollection|array
    {
        return $this->employees;
    }
}
