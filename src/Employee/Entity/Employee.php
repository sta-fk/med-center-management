<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Appointments\Entity\Appointments;
use App\Employee\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \App\Division\Entity\Division;
use \App\LegalEntity\Entity\LegalEntity;
use \App\Department\Entity\Department;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
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
    private $employeeType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\OneToOne(targetEntity=EmployeeInfo::class, mappedBy="employee", cascade={"persist", "remove"})
     */
    private $employeeInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $brief;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeEducation::class, mappedBy="employee")
     */
    private $educations;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeQualification::class, mappedBy="employee")
     */
    private $qualifications;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeSpeciality::class, mappedBy="employee")
     */
    private $specialities;

    /**
     * @ORM\ManyToOne(targetEntity=Division::class, inversedBy="employees", cascade={"persist"})
     */
    private $division;

    /**
     * @ORM\ManyToOne(targetEntity=LegalEntity::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $legalEntity;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="employees")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\ManyToMany(targetEntity=Appointments::class, mappedBy="employee")
     */
    private $appointments;

    /**
     * @ORM\Column(type="time_immutable")
     */
    private $startWorkHours;

    /**
     * @ORM\Column(type="time_immutable")
     */
    private $endWorkHours;

    public function __construct()
    {
        $this->educations = new ArrayCollection();
        $this->qualifications = new ArrayCollection();
        $this->specialities = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmployeeType(): ?string
    {
        return $this->employeeType;
    }

    public function setEmployeeType(string $employeeType): self
    {
        $this->employeeType = $employeeType;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getBrief(): ?string
    {
        return $this->brief;
    }

    public function setBrief(string $brief): self
    {
        $this->brief = $brief;

        return $this;
    }

    public function getEmployeeInfo(): ?EmployeeInfo
    {
        return $this->employeeInfo;
    }

    public function setEmployeeInfo(EmployeeInfo $employeeInfo): self
    {
        // set the owning side of the relation if necessary
        if ($employeeInfo->getEmployee() !== $this) {
            $employeeInfo->setEmployee($this);
        }

        $this->employeeInfo = $employeeInfo;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeEducation>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEmployeeEducation(EmployeeEducation $employeeEducation): self
    {
        if (!$this->educations->contains($employeeEducation)) {
            $this->educations[] = $employeeEducation;
            $employeeEducation->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeEducation(EmployeeEducation $employeeEducation): self
    {
        if ($this->educations->removeElement($employeeEducation)) {
            // set the owning side to null (unless already changed)
            if ($employeeEducation->getEmployee() === $this) {
                $employeeEducation->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeQualification>
     */
    public function getQualifications(): Collection
    {
        return $this->qualifications;
    }

    public function addEmployeeQualification(EmployeeQualification $employeeQualification): self
    {
        if (!$this->qualifications->contains($employeeQualification)) {
            $this->qualifications[] = $employeeQualification;
            $employeeQualification->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeQualification(EmployeeQualification $employeeQualification): self
    {
        if ($this->qualifications->removeElement($employeeQualification)) {
            // set the owning side to null (unless already changed)
            if ($employeeQualification->getEmployee() === $this) {
                $employeeQualification->setEmployee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeSpeciality>
     */
    public function getSpecialities(): Collection
    {
        return $this->specialities;
    }

    public function addEmployeeSpeciality(EmployeeSpeciality $employeeSpeciality): self
    {
        if (!$this->specialities->contains($employeeSpeciality)) {
            $this->specialities[] = $employeeSpeciality;
            $employeeSpeciality->setEmployee($this);
        }

        return $this;
    }

    public function removeEmployeeSpeciality(EmployeeSpeciality $employeeSpeciality): self
    {
        if ($this->specialities->removeElement($employeeSpeciality)) {
            // set the owning side to null (unless already changed)
            if ($employeeSpeciality->getEmployee() === $this) {
                $employeeSpeciality->setEmployee(null);
            }
        }

        return $this;
    }

    public function getDivision(): ?Division
    {
        return $this->division;
    }

    public function setDivision(?Division $division): self
    {
        $this->division = $division;

        return $this;
    }

    public function getLegalEntity(): ?LegalEntity
    {
        return $this->legalEntity;
    }

    public function setLegalEntity(?LegalEntity $legalEntity): self
    {
        $this->legalEntity = $legalEntity;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection<int, Appointments>
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointments $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->addEmployee($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            $appointment->removeEmployee($this);
        }

        return $this;
    }

    public function getStartWorkHours(): ?\DateTimeImmutable
    {
        return $this->startWorkHours;
    }

    public function setStartWorkHours(\DateTimeImmutable $startWorkHours): self
    {
        $this->startWorkHours = $startWorkHours;

        return $this;
    }

    public function getEndWorkHours(): ?\DateTimeImmutable
    {
        return $this->endWorkHours;
    }

    public function setEndWorkHours(\DateTimeImmutable $endWorkHours): self
    {
        $this->endWorkHours = $endWorkHours;

        return $this;
    }
}
