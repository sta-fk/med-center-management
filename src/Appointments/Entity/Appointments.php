<?php declare(strict_types=1);

namespace App\Appointments\Entity;

use App\Appointments\Repository\AppointmentsRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Catalog\Entity\Service;
use App\Employee\Entity\Employee;
use App\PatientUser\Entity\PatientProfile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentsRepository::class)
 * @UniqueEntity(fields={"time"}, errorPath="time", message="api.appointment.unavailable_time")
 */
class Appointments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Employee::class, inversedBy="appointments")
     */
    private $employee;

    /**
     * @ORM\ManyToMany(targetEntity=PatientProfile::class, inversedBy="appointments")
     */
    private $patient;

    /**
     * @ORM\ManyToMany(targetEntity=Service::class, inversedBy="appointments")
     */
    private $service;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $time;

    public function __construct()
    {
        $this->employee = new ArrayCollection();
        $this->patient = new ArrayCollection();
        $this->service = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        $this->employee->removeElement($employee);

        return $this;
    }

    /**
     * @return Collection<int, PatientProfile>
     */
    public function getPatient(): Collection
    {
        return $this->patient;
    }

    public function addPatient(PatientProfile $patient): self
    {
        if (!$this->patient->contains($patient)) {
            $this->patient[] = $patient;
        }

        return $this;
    }

    public function removePatient(PatientProfile $patient): self
    {
        $this->patient->removeElement($patient);

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getService(): Collection
    {
        return $this->service;
    }

    public function addService(Service $service): self
    {
        if (!$this->service->contains($service)) {
            $this->service[] = $service;
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        $this->service->removeElement($service);

        return $this;
    }

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): self
    {
        $this->time = $time;

        return $this;
    }
}
