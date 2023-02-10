<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model;

final class ShopInfo
{
    private ?string $agency;

    private ?bool $autoDiscount;

    private string $company;

    private ?string $email;

    private string $name;

    private ?string $platform;

    private string $url;

    private ?string $version;

    public function __construct(
        string  $company,
        string  $name,
        string  $url,
        ?string $agency = null,
        ?bool   $autoDiscount = null,
        ?string $email = null,
        ?string $platform = null,
        ?string $version = null,
    ) {
        $this->agency = $agency;
        $this->autoDiscount = $autoDiscount;
        $this->company = $company;
        $this->email = $email;
        $this->name = $name;
        $this->platform = $platform;
        $this->url = $url;
        $this->version = $version;
    }

    public function getAgency(): ?string
    {
        return $this->agency;
    }

    public function setAgency(?string $agency): self
    {
        $this->agency = $agency;

        return $this;
    }

    public function getAutoDiscount(): ?bool
    {
        return $this->autoDiscount;
    }

    public function setAutoDiscount(?bool $autoDiscount): self
    {
        $this->autoDiscount = $autoDiscount;

        return $this;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): self
    {
        $this->platform = $platform;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(?string $version): self
    {
        $this->version = $version;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name'                  => $this->getName(),
            'company'               => $this->getCompany(),
            'url'                   => $this->getUrl(),
            'platform'              => $this->getPlatform(),
            'version'               => $this->getVersion(),
            'agency'                => $this->getAgency(),
            'email'                 => $this->getEmail(),
            'enable_auto_discounts' => $this->getAutoDiscount(),
        ];
    }
}
