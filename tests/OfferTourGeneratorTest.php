<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferTour;

final class OfferTourGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Tour';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return (new OfferTour(
            categoryId: 999,
            currencyId: CurrencyEnum::RUB,
            days: $this->faker->numberBetween(1, 9999),
            id: $this->faker->name,
            included: $this->faker->name,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            transport: $this->faker->name,
            url: $this->faker->url
        ))
            ->setWorldRegion($this->faker->name)
            ->setCountry($this->faker->name)
            ->setRegion($this->faker->name)
            ->addDataTour($this->faker->date("Y-m-d\TH:i"))
            ->setName($this->faker->name)
            ->setHotelStars($this->faker->name)
            ->setRoom($this->faker->name)
            ->setMeal($this->faker->name);
    }
}
