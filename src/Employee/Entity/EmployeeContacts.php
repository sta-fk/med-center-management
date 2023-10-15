<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Base\Entity\AbstractContacts;
use App\Employee\Repository\EmployeeContactsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeContactsRepository::class)
 */
class EmployeeContacts extends AbstractContacts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=EmployeeInfo::class, inversedBy="phones", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employeeInfo;

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmployeeInfo(): ?EmployeeInfo
    {
        return $this->employeeInfo;
    }

    public function setEmployeeInfo(?EmployeeInfo $employeeInfo): self
    {
        $this->employeeInfo = $employeeInfo;

        return $this;
    }
}
