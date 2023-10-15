<?php declare(strict_types=1);

namespace App\Employee\Entity;

use App\Employee\Repository\EmployeeInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeInfoRepository::class)
 */
class EmployeeInfo
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $inn;

    /**
     * @ORM\Column(type="smallint")
     */
    private $workingExperience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $aboutMyself;

    /**
     * @ORM\Column(type="smallint")
     */
    private $declarationLimit;

    /**
     * @ORM\Column(type="smallint")
     */
    private $declarationCount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=EmployeeContacts::class, mappedBy="employeeInfo")
     */
    private $phones;

    /**
     * @ORM\OneToOne(targetEntity=Employee::class, inversedBy="employeeInfo", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $employee;

    public function __construct()
    {
        $this->phones = new ArrayCollection();
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

    public function getBirthDate(): ?\DateTimeImmutable
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeImmutable $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function isGender(): ?bool
    {
        return $this->gender;
    }

    public function setGender(bool $gender): self
    {
        $this->gender = $gender;

        return $this;
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

    public function getWorkingExperience(): ?int
    {
        return $this->workingExperience;
    }

    public function setWorkingExperience(int $workingExperience): self
    {
        $this->workingExperience = $workingExperience;

        return $this;
    }

    public function getAboutMyself(): ?string
    {
        return $this->aboutMyself;
    }

    public function setAboutMyself(string $aboutMyself): self
    {
        $this->aboutMyself = $aboutMyself;

        return $this;
    }

    public function getDeclarationLimit(): ?int
    {
        return $this->declarationLimit;
    }

    public function setDeclarationLimit(int $declarationLimit): self
    {
        $this->declarationLimit = $declarationLimit;

        return $this;
    }

    public function getDeclarationCount(): ?int
    {
        return $this->declarationCount;
    }

    public function setDeclarationCount(int $declarationCount): self
    {
        $this->declarationCount = $declarationCount;

        return $this;
    }

    /**
     * @return Collection<int, EmployeeContacts>
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(EmployeeContacts $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->setEmployeeInfo($this);
        }

        return $this;
    }

    public function removePhone(EmployeeContacts $phone): self
    {
        if ($this->phones->removeElement($phone)) {
            // set the owning side to null (unless already changed)
            if ($phone->getEmployeeInfo() === $this) {
                $phone->setEmployeeInfo(null);
            }
        }

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
}
