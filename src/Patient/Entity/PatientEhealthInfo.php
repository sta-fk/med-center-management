<?php

namespace App\Patient\Entity;

use App\Patient\Repository\PatientEhealthInfoRepository;
use App\PatientUser\Entity\PatientProfile;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientEhealthInfoRepository::class)
 */
class PatientEhealthInfo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=PatientProfile::class, inversedBy="patientEhealthInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patientId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $declarationId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfile(): ?PatientProfile
    {
        return $this->profile;
    }

    public function setProfile(PatientProfile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getPatientId(): ?string
    {
        return $this->patientId;
    }

    public function setPatientId(string $patientId): self
    {
        $this->patientId = $patientId;

        return $this;
    }

    public function getDeclarationId(): ?string
    {
        return $this->declarationId;
    }

    public function setDeclarationId(string $declarationId): self
    {
        $this->declarationId = $declarationId;

        return $this;
    }
}
