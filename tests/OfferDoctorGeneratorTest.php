<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Category;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferDoctor;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Set;

final class OfferDoctorGeneratorTest extends AbstractGeneratorTest
{
    public function testGenerate(): void
    {
        $this->offerType = 'Doctor';
        $this->runGeneratorTest();
    }

    protected function createCategories(): array
    {
        $categories = [];
        $categories[] = new Category(id: 1, name: 'Врач');

        return $categories;
    }

    protected function createOffer(): OfferInterface
    {
        return new OfferDoctor(
            categoryId: $this->faker->numberBetween(),
            currencyId: CurrencyEnum::RUB,
            id: $this->faker->name,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            url: $this->faker->url,
            ids: ['terapevt', 'khirurg']
        );
    }

    protected function createSets(): array
    {
        $sets = [];
        $sets[] = new Set(id: 'terapevt', name: 'Терапевт', url: $this->faker->url);
        $sets[] = new Set(id: 'khirurg', name: 'Хирург', url: $this->faker->url);

        return $sets;
    }
}
