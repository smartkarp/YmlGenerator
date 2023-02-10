<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

final class OfferParam
{
    private string $name;

    private ?string $unit;

    private string $value;

    public function __construct(string $name, string $value, ?string $unit = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->unit = $unit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
