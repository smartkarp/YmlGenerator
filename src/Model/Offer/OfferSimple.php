<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

final class OfferSimple extends AbstractOffer implements OfferGroupAwareInterface
{
    use OfferGroupTrait;

    private ?string $vendor = null;

    private ?string $vendorCode = null;

    public function getType(): ?string
    {
        return null;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(?string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getVendorCode(): ?string
    {
        return $this->vendorCode;
    }

    public function setVendorCode(?string $vendorCode): self
    {
        $this->vendorCode = $vendorCode;

        return $this;
    }

    protected function getOptions(): array
    {
        $data = [
            'name'       => $this->getName(),
            'vendor'     => $this->getVendor(),
            'vendorCode' => $this->getVendorCode(),
        ];

        if ($this->getVendor() !== null) {
            $data['vendor'] = $this->getVendor();
        }

        if ($this->getVendorCode() !== null) {
            $data['vendorCode'] = $this->getVendorCode();
        }

        return $data;
    }
}
