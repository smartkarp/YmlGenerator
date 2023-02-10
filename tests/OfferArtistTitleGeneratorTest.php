<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferArtistTitle;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;

final class OfferArtistTitleGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'ArtistTitle';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return new OfferArtistTitle(
            categoryId: $this->faker->numberBetween(),
            currencyId: CurrencyEnum::RUB,
            id: $this->faker->name,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            title: $this->faker->name,
            url: $this->faker->url
        );
    }
}
