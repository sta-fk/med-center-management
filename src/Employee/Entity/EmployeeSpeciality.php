<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Employee\Repository\EmployeeSpecialityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeSpecialityRepository::class)
 */
class EmployeeSpeciality
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
    private $speciality;

    /**
     * @ORM\Column(type="boolean")
     */
    private $specialityOfficio;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $qualificationType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $attestationName;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $attestationDate;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $validTo;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="employeeSpecialities", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function getId(): ?int
    {
        return $this->id;
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

    public function isSpecialityOfficio(): ?bool
    {
        return $this->specialityOfficio;
    }

    public function setSpecialityOfficio(bool $specialityOfficio): self
    {
        $this->specialityOfficio = $specialityOfficio;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getQualificationType(): ?string
    {
        return $this->qualificationType;
    }

    public function setQualificationType(string $qualificationType): self
    {
        $this->qualificationType = $qualificationType;

        return $this;
    }

    public function getAttestationName(): ?string
    {
        return $this->attestationName;
    }

    public function setAttestationName(string $attestationName): self
    {
        $this->attestationName = $attestationName;

        return $this;
    }

    public function getAttestationDate(): ?\DateTimeImmutable
    {
        return $this->attestationDate;
    }

    public function setAttestationDate(\DateTimeImmutable $attestationDate): self
    {
        $this->attestationDate = $attestationDate;

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
