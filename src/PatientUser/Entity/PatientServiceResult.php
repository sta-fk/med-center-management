<?php declare(strict_types=1);

namespace App\PatientUser\Entity;

use App\Catalog\Entity\Service;
use App\PatientUser\Repository\PatientServiceResultRepository;
use Doctrine\ORM\Mapping as ORM;
use \App\Appointments\Entity\Appointments;

/**
 * @ORM\Entity(repositoryClass=PatientServiceResultRepository::class)
 */
class PatientServiceResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PatientProfile::class, inversedBy="appointmentResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @ORM\OneToOne(targetEntity=Appointments::class, cascade={"persist", "remove"})
     */
    private $appointment;

    /**
     * @ORM\Column(type="json")
     */
    private $result = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?PatientProfile
    {
        return $this->patient;
    }

    public function setPatient(?PatientProfile $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAppointment(): ?Appointments
    {
        return $this->appointment;
    }

    public function setAppointment(Appointments $appointment): self
    {
        $this->appointment = $appointment;

        return $this;
    }

    public function getResult(): ?array
    {
        return $this->result;
    }

    public function setResult(array $result): self
    {
        $this->result = $result;

        return $this;
    }
}
