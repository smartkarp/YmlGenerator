<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

final class OfferBook extends AbstractOffer
{
    use OfferBookTrait;

    private const TYPE = 'book';

    private ?string $binding = null;

    private ?int $pageExtent = null;

    public function getBinding(): ?string
    {
        return $this->binding;
    }

    public function setBinding(?string $binding): self
    {
        $this->binding = $binding;

        return $this;
    }

    public function getPageExtent(): ?int
    {
        return $this->pageExtent;
    }

    public function setPageExtent(?int $pageExtent): self
    {
        $this->pageExtent = $pageExtent;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    protected function getOptions(): array
    {
        $data = $this->getTraitOptions();

        if ($this->getBinding() !== null) {
            $data['binding'] = $this->getBinding();
        }

        if ($this->getPageExtent() !== null) {
            $data['page_extent'] = $this->getPageExtent();
        }

        if ($this->getTableOfContents() !== null) {
            $data['table_of_contents'] = $this->getTableOfContents();
        }

        return $data;
    }
}
