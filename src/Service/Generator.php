<?php

namespace Smartkarp\Bundle\YmlGeneratorBundle\Service;

use Smartkarp\Bundle\YmlGeneratorBundle\Model\Category;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Currency;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Delivery;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferCondition;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferGroupAwareInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferInterface;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\Offer\OfferParam;
use Smartkarp\Bundle\YmlGeneratorBundle\Model\ShopInfo;
use Exception;
use LogicException;
use RuntimeException;
use XMLWriter;
use function copy;
use function count;
use function date;
use function is_array;
use function is_bool;
use function sprintf;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

final class Generator
{
    private Settings $settings;

    private ?string $tmpFile = null;

    private XMLWriter $writer;

    public function __construct()
    {
        $this->settings = new Settings();
        $this->writer = new XMLWriter();
    }

    public function generate(
        ShopInfo $shopInfo,
        array    $currencies,
        array    $categories,
        array    $offers,
        array    $deliveries = []
    ): bool {
        try {
            $this->addHeader();

            $this->addShopInfo($shopInfo);
            $this->addCurrencies($currencies);
            $this->addCategories($categories);

            if (count($deliveries) !== 0) {
                $this->addDeliveries($deliveries);
            }

            $this->addOffers($offers);
            $this->addFooter();

            if ($this->settings->getReturnResultYMLString()) {
                return $this->writer->flush();
            }

            if (null !== $this->settings->getOutputFile()) {
                copy($this->tmpFile, $this->settings->getOutputFile());
                @unlink($this->tmpFile);
            }

            return true;
        } catch (Exception $exception) {
            throw new RuntimeException(
                sprintf('Problem with generating YML file: %s.', $exception->getMessage()),
                0,
                $exception
            );
        }
    }

    public function setSettings(Settings $settings): self
    {
        $this->settings = $settings;

        if ($this->settings->getOutputFile() !== null && $this->settings->getReturnResultYMLString()) {
            throw new LogicException('Only one destination need to be used ReturnResultYMLString or OutputFile.');
        }

        if ($this->settings->getReturnResultYMLString()) {
            $this->writer->openMemory();
        } else {
            $this->tmpFile = $this->settings->getOutputFile() !== null
                ? tempnam(sys_get_temp_dir(), 'YMLGenerator')
                : 'php://output';
            $this->writer->openURI($this->tmpFile);
        }

        if ($this->settings->getIndentString()) {
            $this->writer->setIndentString($this->settings->getIndentString());
            $this->writer->setIndent(true);
        }

        return $this;
    }

    /**
     * Adds <categories> element.
     * (See https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#categories)
     */
    private function addCategories(array $categories): void
    {
        $this->writer->startElement('categories');

        foreach ($categories as $category) {
            if ($category instanceof Category) {
                $this->addCategory($category);
            }
        }

        $this->writer->fullEndElement();
    }

    private function addCategory(Category $category): void
    {
        $this->writer->startElement('category');
        $this->writer->writeAttribute('id', $category->getId());

        if ($category->getParentId() !== null) {
            $this->writer->writeAttribute('parentId', $category->getParentId());
        }

        if (!empty($category->getAttributes())) {
            foreach ($category->getAttributes() as $attribute) {
                $this->writer->writeAttribute($attribute['name'], $attribute['value']);
            }
        }

        $this->writer->text($category->getName());
        $this->writer->fullEndElement();
    }

    /**
     * Adds <currencies> element.
     * (See https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#currencies)
     */
    private function addCurrencies(array $currencies): void
    {
        $this->writer->startElement('currencies');

        foreach ($currencies as $currency) {
            if ($currency instanceof Currency) {
                $this->addCurrency($currency);
            }
        }

        $this->writer->fullEndElement();
    }

    private function addCurrency(Currency $currency): void
    {
        $this->writer->startElement('currency');
        $this->writer->writeAttribute('id', $currency->getId());
        $this->writer->writeAttribute('rate', $currency->getRate());
        $this->writer->endElement();
    }

    /**
     * Adds <delivery-option> element. (See https://yandex.ru/support/partnermarket/elements/delivery-options.xml)
     */
    private function addDeliveries(array $deliveries): void
    {
        $this->writer->startElement('delivery-options');

        foreach ($deliveries as $delivery) {
            if ($delivery instanceof Delivery) {
                $this->addDelivery($delivery);
            }
        }

        $this->writer->fullEndElement();
    }

    private function addDelivery(Delivery $delivery): void
    {
        $this->writer->startElement('option');
        $this->writer->writeAttribute('cost', $delivery->getCost());
        $this->writer->writeAttribute('days', $delivery->getDays());

        if ($delivery->getOrderBefore() !== null) {
            $this->writer->writeAttribute('order-before', $delivery->getOrderBefore());
        }

        $this->writer->endElement();
    }

    private function addFooter(): void
    {
        $this->writer->fullEndElement();
        $this->writer->fullEndElement();
        $this->writer->endDocument();
    }

    private function addHeader(): void
    {
        $this->writer->startDocument('1.0', $this->settings->getEncoding());
        $this->writer->startDTD('yml_catalog', null, 'shops.dtd');
        $this->writer->endDTD();
        $this->writer->startElement('yml_catalog');
        $this->writer->writeAttribute('date', date(DATE_RFC3339));
        $this->writer->startElement('shop');
    }

    private function addOffer(OfferInterface $offer): void
    {
        $this->writer->startElement('offer');
        $this->writer->writeAttribute('id', $offer->getId());
        $this->writer->writeAttribute('available', $offer->isAvailable() ? 'true' : 'false');

        if ($offer->getType() !== null) {
            $this->writer->writeAttribute('type', $offer->getType());
        }

        if ($offer instanceof OfferGroupAwareInterface && $offer->getGroupId() !== null) {
            $this->writer->writeAttribute('group_id', $offer->getGroupId());
        }

        foreach ($offer->toArray() as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $itemValue) {
                    $this->addOfferElement($name, $itemValue);
                }
            } else {
                $this->addOfferElement($name, $value);
            }
        }

        $this->addOfferParams($offer);
        $this->addOfferDeliveryOptions($offer);
        $this->addOfferCondition($offer);

        $this->writer->fullEndElement();
    }

    private function addOfferCondition(OfferInterface $offer): void
    {
        $params = $offer->getCondition();

        if ($params instanceof OfferCondition) {
            $this->writer->startElement('condition');
            $this->writer->writeAttribute('type', $params->getType());
            $this->writer->writeElement('reason', $params->getReasonText());
            $this->writer->endElement();
        }
    }

    private function addOfferDeliveryOptions(OfferInterface $offer): void
    {
        $options = $offer->getDeliveryOptions();

        if (!empty($options)) {
            $this->addDeliveries($options);
        }
    }

    private function addOfferElement(string $name, mixed $value): void
    {
        if ($value === null) {
            return;
        }

        if ($value instanceof Cdata) {
            $this->writer->startElement($name);
            $this->writer->writeCdata((string) $value);
            $this->writer->endElement();

            return;
        }

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        $this->writer->writeElement($name, $value);
    }

    private function addOfferParams(OfferInterface $offer): void
    {
        foreach ($offer->getParams() as $param) {
            if ($param instanceof OfferParam) {
                $this->writer->startElement('param');

                $this->writer->writeAttribute('name', $param->getName());

                if ($param->getUnit()) {
                    $this->writer->writeAttribute('unit', $param->getUnit());
                }

                $this->writer->text($param->getValue());

                $this->writer->endElement();
            }
        }
    }

    /**
     * Adds <offers> element. (See https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#offers)
     */
    private function addOffers(array $offers): void
    {
        $this->writer->startElement('offers');

        foreach ($offers as $offer) {
            if ($offer instanceof OfferInterface) {
                $this->addOffer($offer);
            }
        }

        $this->writer->fullEndElement();
    }

    /**
     * Adds shop element data. (See https://yandex.ru/support/webmaster/goods-prices/technical-requirements.xml#shop)
     */
    private function addShopInfo(ShopInfo $shopInfo): void
    {
        foreach ($shopInfo->toArray() as $name => $value) {
            if ($value !== null) {
                $this->writer->writeElement($name, $value);
            }
        }
    }
}
