<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;

final class OfferTour extends AbstractOffer
{
    private const TYPE = 'tour';

    private ?string $country = null;

    private array $dataTour = [];

    private int $days;

    private ?float $hotelStars = null;

    private string $included;

    private ?string $meal = null;

    private ?string $region = null;

    private ?string $room = null;

    private string $transport;

    private ?string $worldRegion = null;

    public function __construct(
        int          $categoryId,
        CurrencyEnum $currencyId,
        int          $days,
        string       $id,
        string       $included,
        string       $name,
        float        $price,
        string       $transport,
        string       $url
    ) {
        parent::__construct($categoryId, $currencyId, $id, $name, $price, $url);

        $this->days = $days;
        $this->included = $included;
        $this->transport = $transport;
    }

    public function addDataTour(string $dataTour): self
    {
        $this->dataTour[] = $dataTour;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getDataTour(): array
    {
        return $this->dataTour;
    }

    public function setDataTour(array $dataTour): self
    {
        $this->dataTour = $dataTour;

        return $this;
    }

    public function getDays(): int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getHotelStars(): ?float
    {
        return $this->hotelStars;
    }

    public function setHotelStars(?float $hotelStars): self
    {
        $this->hotelStars = $hotelStars;

        return $this;
    }

    public function getIncluded(): string
    {
        return $this->included;
    }

    public function setIncluded(string $included): self
    {
        $this->included = $included;

        return $this;
    }

    public function getMeal(): ?string
    {
        return $this->meal;
    }

    public function setMeal(?string $meal): self
    {
        $this->meal = $meal;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(?string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getTransport(): string
    {
        return $this->transport;
    }

    public function setTransport(string $transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    public function getType(): string
    {
        return self::TYPE;
    }

    public function getWorldRegion(): ?string
    {
        return $this->worldRegion;
    }

    public function setWorldRegion(?string $worldRegion): self
    {
        $this->worldRegion = $worldRegion;

        return $this;
    }

    protected function getOptions(): array
    {
        $data = [
            'days'      => $this->getDays(),
            'name'      => $this->getName(),
            'included'  => $this->getIncluded(),
            'transport' => $this->getTransport(),
        ];

        if ($this->getWorldRegion() !== null) {
            $data['worldRegion'] = $this->getWorldRegion();
        }

        if ($this->getCountry() !== null) {
            $data['country'] = $this->getCountry();
        }

        if ($this->getRegion() !== null) {
            $data['region'] = $this->getRegion();
        }

        if (count($this->getDataTour())) {
            $data['dataTour'] = $this->getDataTour();
        }

        if ($this->getHotelStars() !== null) {
            $data['hotel_stars'] = $this->getHotelStars();
        }

        if ($this->getRoom() !== null) {
            $data['room'] = $this->getRoom();
        }

        if ($this->getMeal() !== null) {
            $data['meal'] = $this->getMeal();
        }

        return $data;
    }
}
