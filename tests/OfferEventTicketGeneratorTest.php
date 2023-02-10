<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferEventTicket;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;

final class OfferEventTicketGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'EventTicket';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return (new OfferEventTicket(
            categoryId: 999,
            currencyId: CurrencyEnum::RUB,
            date: $this->faker->date('d/m/y'),
            id: $this->faker->name,
            name: $this->faker->name,
            place: $this->faker->name,
            price: $this->faker->randomFloat(2),
            url: $this->faker->url,
        ))
            ->setPremiere($this->faker->numberBetween(0, 1))
            ->setKids($this->faker->numberBetween(0, 1));
    }
}
