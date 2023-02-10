<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

interface OfferGroupAwareInterface
{
    public function getGroupId(): ?int;

    public function setGroupId(int $groupId): self;
}
