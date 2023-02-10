<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

trait OfferGroupTrait
{
    protected ?int $groupId = null;

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }
}
