<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Employee\Repository\EmployeeQualificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeQualificationRepository::class)
 */
class EmployeeQualification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $institutionName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $speciality;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $issuedDate;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $validTo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $additionalInfo;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="employeeQualifications", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getInstitutionName(): ?string
    {
        return $this->institutionName;
    }

    public function setInstitutionName(string $institutionName): self
    {
        $this->institutionName = $institutionName;

        return $this;
    }

    public function getSpeciality(): ?string
    {
        return $this->speciality;
    }

    public function setSpeciality(string $speciality): self
    {
        $this->speciality = $speciality;

        return $this;
    }

    public function getIssuedDate(): ?\DateTimeImmutable
    {
        return $this->issuedDate;
    }

    public function setIssuedDate(\DateTimeImmutable $issuedDate): self
    {
        $this->issuedDate = $issuedDate;

        return $this;
    }

    public function getValidTo(): ?\DateTimeImmutable
    {
        return $this->validTo;
    }

    public function setValidTo(\DateTimeImmutable $validTo): self
    {
        $this->validTo = $validTo;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }
}
