<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferSimple;

final class OfferSimpleGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Simple';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
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
            ->setGroupId($this->faker->numberBetween())
            ->addPicture('http://example.com/example.jpeg')
            ->addBarcode($this->faker->ean13)
            ->setCategoriesId([1, 2, 3]);
    }
}
