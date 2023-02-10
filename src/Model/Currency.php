<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;

final class Currency
{
    private CurrencyEnum $id;

    private float $rate;

    public function __construct(CurrencyEnum $id, float $rate = 1)
    {
        $this->id = $id;
        $this->rate = $rate;
    }

    public function getId(): string
    {
        return $this->id->value;
    }

    public function setId(CurrencyEnum $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }
}
