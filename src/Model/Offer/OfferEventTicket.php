<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;

final class OfferEventTicket extends AbstractOffer
{
    private const TYPE = 'event-ticket';

    private string $date;

    private ?bool $kids = null;

    private string $place;

    private ?bool $premiere = null;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        string       $date,
        string       $id,
        string       $name,
        string       $place,
        float        $price,
        string       $url
    ) {
        parent::__construct($categoryId, $currencyId, $id, $name, $price, $url);

        $this->date = $date;
        $this->place = $place;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getKids(): ?bool
    {
        return $this->kids;
    }

    public function setKids(?bool $kids): self
    {
        $this->kids = $kids;

        return $this;
    }

    public function getPlace(): string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getPremiere(): ?bool
    {
        return $this->premiere;
    }

    public function setPremiere(?bool $premiere): self
    {
        $this->premiere = $premiere;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    protected function getOptions(): array
    {
        $data = [
            'name'  => $this->getName(),
            'place' => $this->getPlace(),
            'date'  => $this->getDate(),
        ];

        if ($this->getPremiere() !== null) {
            $data['is_premiere'] = $this->getPremiere();
        }

        if ($this->getKids() !== null) {
            $data['is_kids'] = $this->getKids();
        }

        return $data;
    }
}
