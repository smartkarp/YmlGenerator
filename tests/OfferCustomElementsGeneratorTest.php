<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Smartkarp\Bundle\YmlGeneratorBundle\Cdata;
use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferSimple;
use function range;

final class OfferCustomElementsGeneratorTest extends AbstractGeneratorTest
{
    private const CDATA_TEST_STRING = '<p>Simple HTML</p></description></offer><![CDATA[';
    private const OFFER_COUNT = 2;

    public function testGenerate(): void
    {
        // Don't call $this->validateFileWithDtd() here because custom elements are not included into the default DTD
        $this->generateFile();
        $this->checkCustomElements();
    }

    /**
     * Set the test description with CDATA here
     *
     * @see AbstractGeneratorTest::createOffer()
     */
    protected function createOffer(): OfferInterface
    {
        $offer = (new OfferSimple(
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
            ->setDescription($this->faker->sentence)
            ->setVendorCode(null)
            ->setPickup(true)
            ->addPicture('http://example.com/example.jpeg')
            ->addBarcode($this->faker->ean13)
            ->setCustomElements(['custom_element' => [100500, 'string value']])
            ->addCustomElement('custom_element', true)
            ->addCustomElement('custom_element', false)
            ->addCustomElement('custom_element', null) // Should not be written
            ->addCustomElement('custom_element', $cdata = new Cdata(self::CDATA_TEST_STRING))
            ->addCustomElement('stock_quantity', 100);

        $this->assertSame(
            [100500, 'string value', true, false, $cdata],
            $offer->getCustomElementByType('custom_element')
        );
        $this->assertSame([100], $offer->getCustomElementByType('stock_quantity'));
        $this->assertSame([], $offer->getCustomElementByType('non_existent_element'));

        return $offer;
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
     * Load generated XML file and check custom elements
     */
    private function checkCustomElements(): void
    {
        // Much easier to test with SimpleXML tahn with DOM
        $yml = simplexml_load_string(file_get_contents($this->settings->getOutputFile()));

        $offers = $yml->shop->offers->offer;
        $this->assertNotEmpty($offers);
        $this->assertCount(self::OFFER_COUNT, $offers);

        foreach ($offers as $offer) {
            $prop = 'stock_quantity';
            $this->assertSame(100, (int) $offer->$prop); // Can't use $offer->stock_quantity because of CS rules

            $prop = 'custom_element';
            $multipleElements = $offer->$prop; // Can't use $offer->custom_element because of CS rules
            $this->assertNotEmpty($multipleElements);

            // Verity each added value
            $this->assertSame(100500, (int) $multipleElements[0]);
            $this->assertSame('string value', (string) $multipleElements[1]);
            $this->assertSame('true', (string) $multipleElements[2]);
            $this->assertSame('false', (string) $multipleElements[3]);

            // ->addCustomElement('custom_element', null) must not produce an element

            $this->assertSame(self::CDATA_TEST_STRING, (string) $multipleElements[4]);
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
