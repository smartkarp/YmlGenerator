<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model;

final class Category
{
    private array $attributes;

    private int $id;

    private string $name;

    private ?int $parentId;

    public function __construct(int $id, string $name, int $parentId = null, array $attributes = [])
    {
        $this->id = $id;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->attributes = $attributes;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }

    public function pushAttribute(string $attributeName, mixed $value): self
    {
        $this->attributes[] = ['name' => $attributeName, 'value' => $value];

        return $this;
    }
}
