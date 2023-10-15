<?php declare(strict_types=1);

namespace App\Catalog\Entity;

use App\Appointments\Entity\Appointments;
use App\Catalog\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use \App\Department\Entity\Department;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Department::class, inversedBy="services", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $department;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isResearch;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="parentService")
     */
    private $services;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="services")
     */
    private $parentService;

    /**
     * @ORM\ManyToMany(targetEntity=Appointments::class, mappedBy="service")
     */
    private $appointments;

    /**
     * @ORM\Column(type="time_immutable", nullable=true)
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity=ServiceResult::class, mappedBy="service")
     */
    private $templates;

    public function __construct()
    {
        $this->services = new ArrayCollection();
        $this->appointments = new ArrayCollection();
        $this->templates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

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

    public function isResearch(): ?bool
    {
        return $this->isResearch;
    }

    public function setIsResearch(bool $isResearch): self
    {
        $this->isResearch = $isResearch;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getParentService(): ?self
    {
        return $this->parentService;
    }

    public function setParentService(?Service $parentService): self
    {
        $this->parentService = $parentService;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setParentService($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getParentService() === $this) {
                $service->setParentService(null);
            }
        }

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
            $appointment->addService($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            $appointment->removeService($this);
        }

        return $this;
    }

    public function getDuration(): ?\DateTimeImmutable
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeImmutable $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection<int, ServiceResult>
     */
    public function getTemplates(): Collection
    {
        return $this->templates;
    }

    public function addTemplate(ServiceResult $template): self
    {
        if (!$this->templates->contains($template)) {
            $this->templates[] = $template;
            $template->setService($this);
        }

        return $this;
    }

    public function removeTemplate(ServiceResult $template): self
    {
        if ($this->templates->removeElement($template)) {
            // set the owning side to null (unless already changed)
            if ($template->getService() === $this) {
                $template->setService(null);
            }
        }

        return $this;
    }
}
