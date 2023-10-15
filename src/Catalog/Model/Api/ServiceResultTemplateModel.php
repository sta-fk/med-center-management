<?php declare(strict_types=1);

namespace App\Catalog\Model\Api;

use JMS\Serializer\Annotation as JMS;

class ServiceResultTemplateModel
{
    public function __construct(
        private string $name,

        /**
         * @JMS\Exclude(if="object.getChildren() !== null")
         */
        private ?string $result,

        /**
         * @JMS\Exclude(if="object.getUnit() === null")
         */
        private ?string $unit,

        /**
         * @JMS\Exclude(if="object.getRefer() === null")
         */
        private ?string $refer,

        /**
         * @var ServiceResultTemplateModel[]
         *
         * @JMS\Type("array<App\Catalog\Model\Api\ServiceResultTemplateModel>")
         * @JMS\Exclude(if="object.getChildren() === null")
         */
        private ?array $children,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getRefer(): ?string
    {
        return $this->refer;
    }

    public function getChildren(): ?array
    {
        return $this->children;
    }
}
