<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Delivery;
use Symfony\Component\Validator\Constraints\Length;
use function array_merge;
use function count;
use function implode;
use function round;

abstract class AbstractOffer implements OfferInterface
{
    protected ?bool $adult = null;

    protected ?bool $autoDiscount = null;

    protected ?bool $available = null;

    protected array $barcodes = [];

    protected array $categoriesId = [];

    #[Length(max: 18)]
    protected int $categoryId;

    protected ?OfferCondition $condition = null;

    protected ?string $countryOfOrigin = null;

    protected ?int $cpa = null;

    protected CurrencyEnum $currencyId;

    /**
     * Array of custom elements (element types are keys) of arrays of element values
     * There may be multiple elements of the same type
     */
    protected array $customElements = [];

    protected ?bool $delivery = null;

    /**
     * @var Delivery[]
     */
    protected array $deliveryOptions = [];

    #[Length(max: 3000)]
    protected ?string $description = null;

    protected ?string $dimensions = null;

    protected ?bool $downloadable = null;

    #[Length(max: 20)]
    protected string $id;

    protected ?float $localDeliveryCost = null;

    protected ?bool $manufacturerWarranty = null;

    protected ?string $marketCategory = null;

    protected string $name;

    protected ?float $oldPrice = null;

    /**
     * @var OfferParam[]
     */
    protected array $params = [];

    protected ?bool $pickup = null;

    protected array $pictures = [];

    protected float $price;

    protected ?float $purchasePrice = null;

    protected ?string $salesNotes = null;

    protected ?bool $store = null;

    #[Length(max: 2048)]
    protected string $url;

    protected ?float $weight = null;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        string       $id,
        string       $name,
        float        $price,
        string       $url,
    ) {
        $this->categoryId = $categoryId;
        $this->currencyId = $currencyId;
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->url = $url;
    }

    public function addBarcode(string $barcode): self
    {
        $this->barcodes[] = $barcode;

        return $this;
    }

    public function addCondition(OfferCondition $condition): self
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Add a custom element with given type and value
     * Multiple elements of the same type are supported
     */
    public function addCustomElement(string $elementType, mixed $value): self
    {
        if ($value !== null) {
            $this->customElements[$elementType][] = $value;
        }

        return $this;
    }

    public function addDeliveryOption(Delivery $option): self
    {
        $this->deliveryOptions[] = $option;

        return $this;
    }

    public function addParam(OfferParam $param): self
    {
        $this->params[] = $param;

        return $this;
    }

    public function addPicture(string $url): self
    {
        if (count($this->pictures) < 10) {
            $this->pictures[] = $url;
        }

        return $this;
    }

    public function getAutoDiscount(): ?bool
    {
        return $this->autoDiscount;
    }

    public function setAutoDiscount(bool $autoDiscount): self
    {
        $this->autoDiscount = $autoDiscount;

        return $this;
    }

    public function getBarcodes(): array
    {
        return $this->barcodes;
    }

    public function setBarcodes(array $barcodes = []): self
    {
        $this->barcodes = $barcodes;

        return $this;
    }

    public function getCategoriesId(): array
    {
        return $this->categoriesId;
    }

    public function setCategoriesId(array $categoriesId): self
    {
        $this->categoriesId = $categoriesId;

        return $this;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    public function getCondition(): ?OfferCondition
    {
        return $this->condition;
    }

    public function getCountryOfOrigin(): ?string
    {
        return $this->countryOfOrigin;
    }

    public function setCountryOfOrigin(string $countryOfOrigin): self
    {
        $this->countryOfOrigin = $countryOfOrigin;

        return $this;
    }

    public function getCpa(): ?int
    {
        return $this->cpa;
    }

    public function setCpa(int $cpa): self
    {
        $this->cpa = $cpa;

        return $this;
    }

    public function getCurrencyId(): string
    {
        return $this->currencyId->value;
    }

    public function setCurrencyId(CurrencyEnum $currencyId): self
    {
        $this->currencyId = $currencyId;

        return $this;
    }

    public function getCustomElementByType(string $elementType): array
    {
        return $this->customElements[$elementType] ?? [];
    }

    public function getCustomElements(): array
    {
        return $this->customElements;
    }

    public function setCustomElements(array $customElements = []): self
    {
        $this->customElements = $customElements;

        return $this;
    }

    public function getDeliveryOptions(): array
    {
        return $this->deliveryOptions;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(float $length, float $width, float $height): self
    {
        $dimensions = [
            round($length, 3),
            round($width, 3),
            round($height, 3),
        ];

        $this->dimensions = implode('/', $dimensions);

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getLocalDeliveryCost(): ?float
    {
        return $this->localDeliveryCost;
    }

    public function setLocalDeliveryCost(float $localDeliveryCost): self
    {
        $this->localDeliveryCost = $localDeliveryCost;

        return $this;
    }

    public function getMarketCategory(): ?string
    {
        return $this->marketCategory;
    }

    public function setMarketCategory(string $marketCategory): self
    {
        $this->marketCategory = $marketCategory;

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

    public function getOldPrice(): ?float
    {
        return $this->oldPrice;
    }

    public function setOldPrice(float $oldPrice): self
    {
        $this->oldPrice = $oldPrice;

        return $this;
    }

    /**
     * @return OfferParam[]
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function setPictures(array $pictures): self
    {
        $this->pictures = $pictures;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPurchasePrice(): ?float
    {
        return $this->purchasePrice;
    }

    public function setPurchasePrice(float $purchasePrice): self
    {
        $this->purchasePrice = $purchasePrice;

        return $this;
    }

    public function getSalesNotes(): ?string
    {
        return $this->salesNotes;
    }

    public function setSalesNotes(string $salesNotes): self
    {
        $this->salesNotes = $salesNotes;

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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function isAdult(): ?bool
    {
        return $this->adult;
    }

    public function isAvailable(): ?bool
    {
        return $this->available;
    }

    public function isDelivery(): ?bool
    {
        return $this->delivery;
    }

    public function isDownloadable(): ?bool
    {
        return $this->downloadable;
    }

    public function isManufacturerWarranty(): ?bool
    {
        return $this->manufacturerWarranty;
    }

    public function isPickup(): ?bool
    {
        return $this->pickup;
    }

    public function isStore(): ?bool
    {
        return $this->store;
    }

    public function setAdult(bool $adult): self
    {
        $this->adult = $adult;

        return $this;
    }

    public function setAvailable(bool $available): self
    {
        $this->available = $available;

        return $this;
    }

    public function setDelivery(bool $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    public function setDownloadable(bool $downloadable): self
    {
        $this->downloadable = $downloadable;

        return $this;
    }

    public function setManufacturerWarranty(bool $manufacturerWarranty): self
    {
        $this->manufacturerWarranty = $manufacturerWarranty;

        return $this;
    }

    public function setPickup(bool $pickup): self
    {
        $this->pickup = $pickup;

        return $this;
    }

    public function setStore(bool $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge($this->getHeaderOptions(), $this->getOptions(), $this->getFooterOptions());
    }

    private function getFooterOptions(): array
    {
        $data = [];

        if ($this->getDescription() !== null) {
            $data['description'] = $this->getDescription();
        }

        if ($this->getSalesNotes() !== null) {
            $data['sales_notes'] = $this->getSalesNotes();
        }

        if ($this->isManufacturerWarranty() !== null) {
            $data['manufacturer_warranty'] = $this->isManufacturerWarranty();
        }

        if ($this->isDownloadable() !== null) {
            $data['downloadable'] = $this->isDownloadable();
        }

        if ($this->isAdult() !== null) {
            $data['adult'] = $this->isAdult();
        }

        if ($this->getCpa() !== null) {
            $data['cpa'] = $this->getCpa();
        }

        if (count($this->getBarcodes())) {
            $data['barcode'] = $this->getBarcodes();
        }

        return $data;
    }

    private function getHeaderOptions(): array
    {
        $data = [
            'url'        => $this->getUrl(),
            'price'      => $this->getPrice(),
            'currencyId' => $this->getCurrencyId(),
            'categoryId' => array_merge([$this->getCategoryId()], $this->getCategoriesId()),
            'name'       => $this->getName(),
        ];

        if ($this->getOldPrice() !== null) {
            $data['oldprice'] = $this->getOldPrice();
        }

        if ($this->getPurchasePrice() !== null) {
            $data['purchase_price'] = $this->getPurchasePrice();
        }

        if ($this->getMarketCategory() !== null) {
            $data['market_category'] = $this->getMarketCategory();
        }

        if (count($this->getPictures())) {
            $data['picture'] = $this->getPictures();
        }

        if ($this->isPickup() !== null) {
            $data['pickup'] = $this->isPickup();
        }

        if ($this->isStore() !== null) {
            $data['store'] = $this->isStore();
        }

        if ($this->isDelivery() !== null) {
            $data['delivery'] = $this->isDelivery();
        }

        if ($this->getLocalDeliveryCost() !== null) {
            $data['local_delivery_cost'] = $this->getLocalDeliveryCost();
        }

        if ($this->getWeight() !== null) {
            $data['weight'] = $this->getWeight();
        }

        if ($this->getDimensions() !== null) {
            $data['dimensions'] = $this->getDimensions();
        }

        if ($this->getAutoDiscount() !== null) {
            $data['enable_auto_discounts'] = $this->getAutoDiscount();
        }

        return $data + $this->getCustomElements();
    }

    abstract protected function getOptions(): array;
}
