<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Delivery;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferSimple;

final class OfferDeliveryOptionsGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'OfferDeliveryOptions';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        $delivery = new Delivery(cost: 10, days: 1, orderBefore: 14);

        return (new OfferSimple(
            categoryId: 999,
            currencyId: CurrencyEnum::RUB,
            id: $this->faker->name,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            url: $this->faker->url
        ))
            ->setVendor($this->faker->company)
            ->setVendorCode(null)
            ->setPickup(true)
            ->addDeliveryOption($delivery)
            ->addDeliveryOption($delivery)
            ->setGroupId($this->faker->numberBetween())
            ->addPicture('http://example.com/example.jpeg')
            ->addBarcode($this->faker->ean13)
            ->setCategoriesId([1, 2, 3]);
    }
}
