<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferAudiobook;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;

final class OfferAudiobookGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Audiobook';
        $this->runGeneratorTest();
    }

    protected function createOffer(): OfferInterface
    {
        return (new OfferAudiobook(publisher: $this->faker->name))
            ->setAuthor($this->faker->name)
            ->setName($this->faker->name)
            ->setSeries($this->faker->name)
            ->setYear($this->faker->numberBetween(1, 9999))
            ->setISBN($this->faker->isbn13)
            ->setVolume($this->faker->numberBetween(1, 9999))
            ->setPart($this->faker->numberBetween(1, 9999))
            ->setLanguage($this->faker->name)
            ->setTableOfContents($this->faker->name)
            ->setPerformedBy($this->faker->name)
            ->setPerformanceType($this->faker->name)
            ->setStorage($this->faker->name)
            ->setFormat($this->faker->name)
            ->setRecordingLength($this->faker->name);
    }
}
