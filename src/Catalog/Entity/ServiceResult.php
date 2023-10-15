<?php

namespace App\Catalog\Entity;

use App\Catalog\Repository\ServiceResultRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceResultRepository::class)
 */
class ServiceResult
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $template = [];

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="templates")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemplate(): ?array
    {
        return $this->template;
    }

    public function setTemplate(array $template): self
    {
        $this->template = $template;

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
}
