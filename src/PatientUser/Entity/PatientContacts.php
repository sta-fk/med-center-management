<?php declare(strict_types=1);

namespace App\PatientUser\Entity;

use App\Base\Entity\AbstractContacts;
use App\PatientUser\Repository\PatientContactsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientContactsRepository::class)
 */
class PatientContacts extends AbstractContacts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=PatientProfile::class, inversedBy="contacts", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $patientProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatientProfile(): ?PatientProfile
    {
        return $this->patientProfile;
    }

    public function setPatientProfile(?PatientProfile $patientProfile): self
    {
        $this->patientProfile = $patientProfile;

        return $this;
    }
}
