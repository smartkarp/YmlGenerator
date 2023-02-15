<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Tests;

use Faker\Factory as Faker;
use Faker\Generator as FakerGenerator;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\ShopInfo;
use Smartkarp\Bundle\YmlGeneratorBundle\Service\Generator;
use Smartkarp\Bundle\YmlGeneratorBundle\Service\Settings;
use ValueError;
use function ob_get_clean;
use function ob_start;

final class GeneratorTest extends TestCase
{
    private FakerGenerator $faker;

    public function testExceptionForIncompatibleAnnotations(): void
    {
        $this->expectException(ValueError::class);

        (new Generator())
            ->setSettings((new Settings())->setOutputFile(''))
            ->generate($this->createShopInfo(), [], [], []);
    }

    public function testExceptionIfManyDestinationUsed(): void
    {
        $settings = (new Settings())
            ->setOutputFile('')
            ->setReturnResultYMLString(true);

        $this->expectException(RuntimeException::class);

        (new Generator())->setSettings($settings)->generate($this->createShopInfo(), [], [], []);
    }

    /**
     * Test equal returned value and printed
     */
    public function testGenerationEchoValueEqualsReturnValue(): void
    {
        $settings = (new Settings())->setReturnResultYMLString(true);
        $value = (new Generator())->setSettings($settings)->generate($this->createShopInfo(), [], [], []);

        ob_start();
        (new Generator())->setSettings(new Settings())->generate($this->createShopInfo(), [], [], []);
        $value2 = ob_get_clean();

        $this->assertEquals($value, $value2);
    }

    protected function setUp(): void
    {
        $this->faker = Faker::create();
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
}
