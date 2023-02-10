<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferBook;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;

final class OfferBookGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Book';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return (new OfferBook(publisher: $this->faker->name))
            ->setAuthor($this->faker->name)
            ->setName($this->faker->name)
            ->setSeries($this->faker->name)
            ->setYear($this->faker->numberBetween(1, 9999))
            ->setISBN($this->faker->isbn13)
            ->setVolume($this->faker->numberBetween(1, 9999))
            ->setPart($this->faker->numberBetween(1, 9999))
            ->setLanguage($this->faker->name)
            ->setBinding($this->faker->name)
            ->setPageExtent($this->faker->numberBetween(1, 9999))
            ->setTableOfContents($this->faker->name);
    }
}
