<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Cdata;
use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferSimple;
use DOMDocument;
use DOMXPath;
use function file_get_contents;
use function range;

final class OfferCdataGeneratorTest extends AbstractGeneratorTest
{
    private const CDATA_TEST_STRING = '<p>Simple HTML</p></description></offer><![CDATA[';
    private const OFFER_COUNT = 2;

    public function testGenerate(): void
    {
        $this->offerType = 'Simple';
        $this->runGeneratorTest();
        $this->checkCdata();
    }

    /**
     * Set the test description with CDATA here
     *
     * @see AbstractGeneratorTest::createOffer()
     */
    protected function createOffer(): OfferInterface
    {
        return (new OfferSimple(
            categoryId: $this->faker->numberBetween(),
            currencyId: CurrencyEnum::RUB,
            id: $this->faker->name,
            name: $this->faker->name,
            price: $this->faker->randomFloat(2),
            url: $this->faker->url
        ))
            ->setAvailable($this->faker->boolean)
            ->setPrice($this->faker->numberBetween(1, 9999))
            ->setOldPrice($this->faker->numberBetween(1, 9999))
            ->setWeight($this->faker->numberBetween(1, 9999))
            ->setDelivery($this->faker->boolean)
            ->setLocalDeliveryCost($this->faker->numberBetween(1, 9999))
            ->setSalesNotes($this->faker->text(45))
            ->setManufacturerWarranty($this->faker->boolean)
            ->setCountryOfOrigin('Украина')
            ->setDownloadable($this->faker->boolean)
            ->setAdult($this->faker->boolean)
            ->setMarketCategory($this->faker->word)
            ->setCpa($this->faker->numberBetween(0, 1))
            ->setBarcodes([$this->faker->ean13, $this->faker->ean13])
            ->setVendor($this->faker->company)
            ->setDescription($this->makeDescription())
            ->setVendorCode(null)
            ->setPickup(true)
            ->setGroupId($this->faker->numberBetween())
            ->addPicture('http://example.com/example.jpeg')
            ->addBarcode($this->faker->ean13);
    }

    /**
     * Need to override parent::createOffers() in order to avoid setting description after calling self::createOffer()
     *
     * @see AbstractGeneratorTest::createOffers()
     */
    protected function createOffers(): array
    {
        $offers = [];
        foreach (range(1, self::OFFER_COUNT) as $id) {
            $offers[] =
                $this->createOffer()
                    ->setId($id)
                    ->setCategoryId($id);
        }

        return $offers;
    }

    /**
     * Retrieve and check CDATA from the generated file
     */
    private function checkCdata(): void
    {
        $ymlFile = new DOMDocument();
        $ymlFile->loadXML(file_get_contents($this->settings->getOutputFile()));

        $xpath = new DOMXPath($ymlFile);
        $descriptionNodes = $xpath->query('//yml_catalog/shop/offers/offer/description');
        self::assertNotFalse($descriptionNodes);

        // One description per offer is expected
        self::assertEquals(self::OFFER_COUNT, $descriptionNodes->length);

        foreach ($descriptionNodes as $descriptionNode) {
            $description = $descriptionNode->nodeValue;

            self::assertSame(self::CDATA_TEST_STRING, $description);
        }
    }

    /**
     * Create instance of Cdata class with a predefined test string
     */
    private function makeDescription(): Cdata
    {
        return new Cdata(self::CDATA_TEST_STRING);
    }
}
