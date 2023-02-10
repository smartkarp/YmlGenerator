<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferCondition;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferCustom;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferParam;

final class OfferCustomGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Custom';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return (new OfferCustom(
            categoryId: $this->faker->numberBetween(),
            currencyId: CurrencyEnum::RUB,
            id: $this->faker->name,
            model: $this->faker->userName,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            typePrefix: $this->faker->colorName,
            url: $this->faker->url,
            vendor: $this->faker->company
        ))
            ->setVendorCode($this->faker->companySuffix)
            ->setGroupId($this->faker->numberBetween())
            ->setStore($this->faker->boolean)
            ->addParam(
                new OfferParam(
                    name: $this->faker->name,
                    value: $this->faker->text(10),
                    unit: $this->faker->text(5)
                )
            )
            ->setPictures(['http://example.com/example.jpeg', 'http://example.com/example2.jpeg'])
            ->addCondition(
                new OfferCondition(
                    reasonText: $this->faker->text(10),
                    type: $this->faker->text(5)
                )
            );
    }
}
