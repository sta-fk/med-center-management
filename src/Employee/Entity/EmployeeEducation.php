<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Employee\Repository\EmployeeEducationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeEducationRepository::class)
 */
class EmployeeEducation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $institutionName;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $issuedDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $degree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $speciality;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="employeeEducation", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getIssuedDate(): ?\DateTimeImmutable
    {
        return $this->issuedDate;
    }

    public function setIssuedDate(\DateTimeImmutable $issuedDate): self
    {
        $this->issuedDate = $issuedDate;

        return $this;
    }

    public function getDegree(): ?string
    {
        return $this->degree;
    }

    public function setDegree(string $degree): self
    {
        $this->degree = $degree;

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
