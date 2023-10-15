<?php declare(strict_types=1);

namespace App\PatientUser\Entity;

use App\PatientUser\Repository\PatientAdditionalInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientAdditionalInfoRepository::class)
 */
class PatientAdditionalInfo
{
    const TYPE_PASSPORT = 1;
    const TYPE_ID_CARD = 2;
    const ALLOWED_DOCUMENT_TYPE = [
        self::TYPE_PASSPORT,
        self::TYPE_ID_CARD
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $inn;

    /**
     * @ORM\Column(type="smallint", options={"default": 1})
     */
    private $documentType = self::TYPE_PASSPORT;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $passportSeries;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     */
    private $passportNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $passportGive;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $passportDate;

    /**
     * @ORM\Column(type="string", length=9, nullable=true)
     */
    private $idCardNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $idCardIssuedBy;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $idCardIssuedAt;

    /**
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $idCardExpiredAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $birthCountry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $birthCity;

    /**
     * @ORM\OneToOne(targetEntity=PatientProfile::class, inversedBy="additionalInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $patientProfile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInn(): ?string
    {
        return $this->inn;
    }

    public function setInn(string $inn): self
    {
        $this->inn = $inn;

        return $this;
    }

    public function getDocumentType(): ?int
    {
        return $this->documentType;
    }

    public function setDocumentType(int $documentType): self
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getPassportSeries(): ?string
    {
        return $this->passportSeries;
    }

    public function setPassportSeries(string $passportSeries): self
    {
        $this->passportSeries = $passportSeries;

        return $this;
    }

    public function getPassportNumber(): ?string
    {
        return $this->passportNumber;
    }

    public function setPassportNumber(?string $passportNumber): self
    {
        $this->passportNumber = $passportNumber;

        return $this;
    }

    public function getPassportGive(): ?string
    {
        return $this->passportGive;
    }

    public function setPassportGive(?string $passportGive): self
    {
        $this->passportGive = $passportGive;

        return $this;
    }

    public function getPassportDate(): ?\DateTimeImmutable
    {
        return $this->passportDate;
    }

    public function setPassportDate(?\DateTimeImmutable $passportDate): self
    {
        $this->passportDate = $passportDate;

        return $this;
    }

    public function getIdCardNumber(): ?string
    {
        return $this->idCardNumber;
    }

    public function setIdCardNumber(?string $idCardNumber): self
    {
        $this->idCardNumber = $idCardNumber;

        return $this;
    }

    public function getIdCardIssuedBy(): ?string
    {
        return $this->idCardIssuedBy;
    }

    public function setIdCardIssuedBy(?string $idCardIssuedBy): self
    {
        $this->idCardIssuedBy = $idCardIssuedBy;

        return $this;
    }

    public function getIdCardIssuedAt(): ?\DateTimeImmutable
    {
        return $this->idCardIssuedAt;
    }

    public function setIdCardIssuedAt(?\DateTimeImmutable $idCardIssuedAt): self
    {
        $this->idCardIssuedAt = $idCardIssuedAt;

        return $this;
    }

    public function getIdCardExpiredAt(): ?\DateTimeImmutable
    {
        return $this->idCardExpiredAt;
    }

    public function setIdCardExpiredAt(?\DateTimeImmutable $idCardExpiredAt): self
    {
        $this->idCardExpiredAt = $idCardExpiredAt;

        return $this;
    }

    public function getGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getBirthCountry(): ?string
    {
        return $this->birthCountry;
    }

    public function setBirthCountry(?string $birthCountry): self
    {
        $this->birthCountry = $birthCountry;

        return $this;
    }

    public function getBirthCity(): ?string
    {
        return $this->birthCity;
    }

    public function setBirthCity(?string $birthCity): self
    {
        $this->birthCity = $birthCity;

        return $this;
    }

    public function getPatientProfile(): ?PatientProfile
    {
        return $this->patientProfile;
    }

    public function setPatientProfile(PatientProfile $patientProfile): self
    {
        $this->patientProfile = $patientProfile;

        return $this;
    }
}
