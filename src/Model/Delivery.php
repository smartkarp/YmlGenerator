<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model;

final class Delivery
{
    private int $cost;

    private int $days;

    private ?int $orderBefore;

    public function __construct(int $cost, int $days, int $orderBefore = null)
    {
        $this->cost = $cost;
        $this->days = $days;
        $this->orderBefore = $orderBefore;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function setCost(int $cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    public function getDays(): int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getOrderBefore(): ?int
    {
        return $this->orderBefore;
    }

    public function setOrderBefore(int $orderBefore): self
    {
        $this->orderBefore = $orderBefore;

        return $this;
    }
}
