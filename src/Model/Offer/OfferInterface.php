<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

interface OfferInterface
{
    public function getCondition(): ?OfferCondition;

    public function getDeliveryOptions(): array;

    public function getId(): string;

    public function getParams(): array;

    public function getType(): ?string;

    public function isAvailable(): ?bool;

    public function toArray(): array;
}
