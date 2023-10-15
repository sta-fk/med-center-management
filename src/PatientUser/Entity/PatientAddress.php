<?php declare(strict_types=1);

namespace App\PatientUser\Entity;

use App\PatientUser\Repository\PatientAddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientAddressRepository::class)
 */
class PatientAddress
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $area;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $settlementType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $settlement;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $district;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $house;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $apartment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $zip;

    /**
     * @ORM\ManyToOne(targetEntity=PatientProfile::class, inversedBy="addresses", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $patientProfile;

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

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(string $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getSettlementType(): ?string
    {
        return $this->settlementType;
    }

    public function setSettlementType(string $settlementType): self
    {
        $this->settlementType = $settlementType;

        return $this;
    }

    public function getSettlement(): ?string
    {
        return $this->settlement;
    }

    public function setSettlement(string $settlement): self
    {
        $this->settlement = $settlement;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(?string $district): self
    {
        $this->district = $district;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getHouse(): ?string
    {
        return $this->house;
    }

    public function setHouse(?string $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(?string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
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
