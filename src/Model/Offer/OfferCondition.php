<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

final class OfferCondition
{
    private string $reasonText;

    private string $type;

    public function __construct(string $reasonText, string $type)
    {
        $this->reasonText = $reasonText;
        $this->type = $type;
    }

    public function getReasonText(): string
    {
        return $this->reasonText;
    }

    public function setReasonText(string $reasonText): self
    {
        $this->reasonText = $reasonText;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
