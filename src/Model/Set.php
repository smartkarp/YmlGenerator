<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model;

final class Set
{
    private string $id;

    private string $name;

    private string $url;

    public function __construct(string $id, string $name, string $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
