<?php declare(strict_types=1);

namespace App\PatientUser\Entity;

use App\Appointments\Entity\Appointments;
use App\Patient\Entity\PatientEhealthInfo;
use App\PatientUser\Repository\PatientProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientProfileRepository::class)
 */
class PatientProfile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $patronymic;

    /**
     * @ORM\OneToOne(targetEntity=PatientUser::class, inversedBy="profile", cascade={"persist", "remove"})
     */
    private PatientUser $user;

    /**
     * @ORM\OneToMany(targetEntity=PatientContacts::class, mappedBy="patientProfile", cascade={"persist"})
     */
    private $contacts;

    /**
     * @ORM\OneToMany(targetEntity=PatientAddress::class, mappedBy="patientProfile", cascade={"persist"})
     */
    private $addresses;

    /**
     * @ORM\OneToOne(targetEntity=PatientAdditionalInfo::class, mappedBy="patientProfile", cascade={"persist", "remove"})
     */
    private PatientAdditionalInfo $additionalInfo;

    /**
     * @ORM\OneToOne(targetEntity=PatientEhealthInfo::class, mappedBy="profile", cascade={"persist", "remove"})
     */
    private ?PatientEhealthInfo $patientEhealthInfo;

    /**
     * @ORM\ManyToMany(targetEntity=Appointments::class, mappedBy="patient")
     */
    private $appointments;

    /**
     * @ORM\OneToMany(targetEntity=PatientServiceResult::class, mappedBy="patient")
     */
    private $appointmentResults;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->addresses = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->appointmentResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getUser(): ?PatientUser
    {
        return $this->user;
    }

    public function setUser(?PatientUser $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, PatientContacts>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(PatientContacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setPatientProfile($this);
        }

        return $this;
    }

    public function removeContact(PatientContacts $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getPatientProfile() === $this) {
                $contact->setPatientProfile(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PatientAddress>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(PatientAddress $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setPatientProfile($this);
        }

        return $this;
    }

    public function removeAddress(PatientAddress $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getPatientProfile() === $this) {
                $address->setPatientProfile(null);
            }
        }

        return $this;
    }

    public function getAdditionalInfo(): ?PatientAdditionalInfo
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(PatientAdditionalInfo $additionalInfo): self
    {
        // set the owning side of the relation if necessary
        if ($additionalInfo->getPatientProfile() !== $this) {
            $additionalInfo->setPatientProfile($this);
        }

        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getPatientEhealthInfo(): ?PatientEhealthInfo
    {
        return $this->patientEhealthInfo;
    }

    public function isPatientInEhealth(): bool
    {
        return $this->patientEhealthInfo
            && $this->patientEhealthInfo->getDeclarationId()
            && $this->patientEhealthInfo->getPatientId();
    }

    public function setPatientEhealthInfo(PatientEhealthInfo $patientEhealthInfo): self
    {
        // set the owning side of the relation if necessary
        if ($patientEhealthInfo->getProfile() !== $this) {
            $patientEhealthInfo->setProfile($this);
        }

        $this->patientEhealthInfo = $patientEhealthInfo;

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
            $appointment->addPatient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            $appointment->removePatient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PatientServiceResult>
     */
    public function getAppointmentResults(): Collection
    {
        return $this->appointmentResults;
    }

    public function addAppointmentResult(PatientServiceResult $appointmentResult): self
    {
        if (!$this->appointmentResults->contains($appointmentResult)) {
            $this->appointmentResults[] = $appointmentResult;
            $appointmentResult->setPatient($this);
        }

        return $this;
    }

    public function removeAppointmentResult(PatientServiceResult $appointmentResult): self
    {
        if ($this->appointmentResults->removeElement($appointmentResult)) {
            // set the owning side to null (unless already changed)
            if ($appointmentResult->getPatient() === $this) {
                $appointmentResult->setPatient(null);
            }
        }

        return $this;
    }
}
