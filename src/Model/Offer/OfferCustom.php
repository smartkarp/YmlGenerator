<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;

final class OfferCustom extends AbstractOffer implements OfferGroupAwareInterface
{
    use OfferGroupTrait;

    private const TYPE = 'vendor.model';

    private string $model;

    private string $typePrefix;

    private string $vendor;

    private ?string $vendorCode = null;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        string       $id,
        string       $model,
        string       $name,
        float        $price,
        string       $typePrefix,
        string       $url,
        string       $vendor,
    ) {
        parent::__construct($categoryId, $currencyId, $id, $name, $price, $url);

        $this->model = $model;
        $this->typePrefix = $typePrefix;
        $this->vendor = $vendor;
    }

    public
    function getModel(): string
    {
        return $this->model;
    }

    public
    function setModel(
        string $model
    ): self {
        $this->model = $model;

        return $this;
    }

    public
    function getType(): string
    {
        return self::TYPE;
    }

    public
    function getTypePrefix(): string
    {
        return $this->typePrefix;
    }

    public
    function setTypePrefix(
        string $typePrefix
    ): self {
        $this->typePrefix = $typePrefix;

        return $this;
    }

    public
    function getVendor(): string
    {
        return $this->vendor;
    }

    public
    function setVendor(
        string $vendor
    ): self {
        $this->vendor = $vendor;

        return $this;
    }

    public
    function getVendorCode(): ?string
    {
        return $this->vendorCode;
    }

    public
    function setVendorCode(
        ?string $vendorCode
    ): self {
        $this->vendorCode = $vendorCode;

        return $this;
    }

    protected
    function getOptions(): array
    {
        $data = [
            'typePrefix' => $this->getTypePrefix(),
            'vendor'     => $this->getVendor(),
            'model'      => $this->getModel(),
        ];

        if ($this->getVendorCode() !== null) {
            $data['vendorCode'] = $this->getVendorCode();
        }

        return $data;
    }
}
