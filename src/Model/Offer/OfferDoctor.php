<?php

declare(strict_types=1);

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use LogicException;
use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use function implode;

final class OfferDoctor extends AbstractOffer
{
    private array $ids;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        string       $id,
        string       $name,
        float        $price,
        string       $url,
        array        $ids,
    ) {
        parent::__construct($categoryId, $currencyId, $id, $name, $price, $url);

        $this->ids = $ids;
    }

    public function getIds(): string
    {
        return implode(',', $this->ids);
    }

    public function setIds(array $ids): self
    {
        $this->ids = $ids;

        return $this;
    }

    public function getType(): ?string
    {
        return null;
    }

    protected function getOptions(): array
    {
        if (!$this->getIds()) {
            throw new LogicException('Ids are required fields.');
        }

        return ['set-ids' => $this->getIds()];
    }
}
