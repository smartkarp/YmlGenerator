<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use DOMDocument;
use DOMImplementation;
use Exception;
use Faker\Factory as Faker;
use Faker\Generator as FakerGenerator;
use PHPUnit\Framework\TestCase;
use Smartkarp\Bundle\YmlGeneratorBundle\Enum\CurrencyEnum;
use Smartkarp\Bundle\YmlGeneratorBundle\Generator;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Category;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Currency;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Delivery;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\ShopInfo;
use Smartkarp\Bundle\YmlGeneratorBundle\Settings;
use function base64_encode;
use function file_get_contents;
use function range;
use function sys_get_temp_dir;
use function tempnam;

abstract class AbstractGeneratorTest extends TestCase
{
    protected array $categories;

    protected array $currencies;

    protected array $deliveries;

    protected FakerGenerator $faker;

    protected string $offerType;

    protected Settings $settings;

    protected ShopInfo $shopInfo;

    protected function createOffers(): array
    {
        $offers = [];

        foreach (range(1, 2) as $id) {
            $offers[] = $this
                ->createOffer()
                ->setId($id)
                ->setAvailable($this->faker->boolean)
                ->setUrl($this->faker->url)
                ->setPrice($this->faker->numberBetween(1, 9999))
                ->setOldPrice($this->faker->numberBetween(1, 9999))
                ->setPurchasePrice($this->faker->numberBetween(1, 9999))
                ->setWeight($this->faker->numberBetween(1, 9999))
                ->setDimensions(
                    $this->faker->randomFloat(3),
                    $this->faker->randomFloat(3),
                    $this->faker->randomFloat(3)
                )
                ->setCurrencyId(CurrencyEnum::UAH)
                ->setCategoryId($id)
                ->setDelivery($this->faker->boolean)
                ->setLocalDeliveryCost($this->faker->numberBetween(1, 9999))
                ->setDescription($this->faker->sentence)
                ->setSalesNotes($this->faker->text(45))
                ->setManufacturerWarranty($this->faker->boolean)
                ->setCountryOfOrigin('Украина')
                ->setDownloadable($this->faker->boolean)
                ->setAdult($this->faker->boolean)
                ->setMarketCategory($this->faker->word)
                ->setCpa($this->faker->numberBetween(0, 1))
                ->setBarcodes([$this->faker->ean13, $this->faker->ean13])
                ->setAutoDiscount($this->faker->boolean);
        }

        return $offers;
    }

    /**
     * Produces an XML file and writes to $this->settings->getOutputFile()
     */
    protected function generateFile(): void
    {
        static::assertTrue(
            (new Generator())
                ->setSettings($this->settings)
                ->generate(
                    $this->shopInfo,
                    $this->currencies,
                    $this->categories,
                    $this->createOffers(),
                    $this->deliveries
                )
        );
    }

    protected function runGeneratorTest(): void
    {
        $this->generateFile();
        $this->validateFileWithDtd();
    }

    protected function setUp(): void
    {
        $this->faker = Faker::create();

        $this->settings = $this->createSettings();
        $this->shopInfo = $this->createShopInfo();
        $this->currencies = $this->createCurrencies();
        $this->categories = $this->createCategories();
        $this->deliveries = $this->createDeliveries();
    }

    private function createCategories(): array
    {
        $categories = [];
        $categories[] = new Category(id: 1, name: $this->faker->name);
        $categories[] = new Category(id: 2, name: $this->faker->name, parentId: 1);

        return $categories;
    }

    private function createCurrencies(): array
    {
        $currencies = [];
        $currencies[] = new Currency(id: CurrencyEnum::UAH, rate: 1);

        return $currencies;
    }

    private function createDeliveries(): array
    {
        $deliveries = [];
        $deliveries[] = new Delivery(cost: 1, days: 2);
        $deliveries[] = new Delivery(cost: 2, days: 1, orderBefore: 14);

        return $deliveries;
    }

    private function createSettings(): Settings
    {
        return (new Settings())
            ->setOutputFile(tempnam(sys_get_temp_dir(), 'YMLGeneratorTest'))
            ->setEncoding('utf-8');
    }

    private function createShopInfo(): ShopInfo
    {
        return new ShopInfo(
            company: $this->faker->company,
            name: $this->faker->name,
            url: $this->faker->url,
            agency: $this->faker->name,
            autoDiscount: $this->faker->boolean,
            email: $this->faker->email,
            platform: $this->faker->name,
            version: $this->faker->numberBetween(1, 999)
        );
    }

    /**
     * Validate yml file using dtd
     */
    private function validateFileWithDtd(): void
    {
        $base64Encode = base64_encode(file_get_contents(__DIR__.'/dtd/'.$this->offerType.'.dtd'));
        $systemId = 'data://text/plain;base64,'.$base64Encode;
        $root = 'yml_catalog';

        $ymlFile = new DOMDocument();
        $ymlFile->loadXML(file_get_contents($this->settings->getOutputFile()));

        $creator = new DOMImplementation();
        $ymlFileWithDtd = $creator->createDocument(null, null, $creator->createDocumentType($root, null, $systemId));
        $ymlFileWithDtd->encoding = 'windows-1251';

        $oldNode = $ymlFile->getElementsByTagName($root)->item(0);
        $newNode = $ymlFileWithDtd->importNode($oldNode, true);
        $ymlFileWithDtd->appendChild($newNode);

        try {
            static::assertTrue($ymlFileWithDtd->validate());
        } catch (Exception $exception) {
            echo $exception->getMessage();
            static::fail('YML file not valid');
        }
    }

    abstract protected function createOffer(): OfferInterface;
}
