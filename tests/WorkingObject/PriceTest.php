<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjectsCustom\PriceCustom;

/**
 * Class PriceTest
 */
class PriceTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $amount       = MockHelper::getFaker()->randomFloat();
        $currencyCode = MockHelper::getFaker()->currencyCode;
        $group        = MockHelper::getFaker()->uuid;
        $tag          = MockHelper::getFaker()->uuid;

        $compositePrice = PriceMock::create();
        $compositePrices = [
            $compositePrice->getCurrencyCode() => $compositePrice,
        ];

        $price  = new Price(
            $amount,
            $currencyCode,
            $tag,
            $group,
            $compositePrices
        );

        $reflectionObject = new \ReflectionObject($price);

        $amountProperty = $reflectionObject->getProperty('amount');
        $amountProperty->setAccessible(true);
        $this->assertEquals($amount, $amountProperty->getValue($price));

        $currencyCodeProperty = $reflectionObject->getProperty('currencyCode');
        $currencyCodeProperty->setAccessible(true);
        $this->assertEquals($currencyCode, $currencyCodeProperty->getValue($price));

        $groupProperty = $reflectionObject->getProperty('group');
        $groupProperty->setAccessible(true);
        $this->assertEquals($group, $groupProperty->getValue($price));

        $tagProperty = $reflectionObject->getProperty('tag');
        $tagProperty->setAccessible(true);
        $this->assertEquals($tag, $tagProperty->getValue($price));

        $compositePricesProperty = $reflectionObject->getProperty('compositePrices');
        $compositePricesProperty->setAccessible(true);

        /** @var Price[] $testCompositePrices */
        $testCompositePrices = $compositePricesProperty->getValue($price);
        foreach ($testCompositePrices as $testCompositePrice) {
            if (empty($compositePrices[$testCompositePrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testCompositePrice, $compositePrices[$testCompositePrice->getCurrencyCode()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $amount       = MockHelper::getFaker()->randomFloat();
        $currencyCode = MockHelper::getFaker()->currencyCode;
        $group        = MockHelper::getFaker()->uuid;
        $tag          = MockHelper::getFaker()->uuid;

        $compositePrice = PriceMock::create();
        $compositePrices = [
            $compositePrice->getCurrencyCode() => $compositePrice,
        ];

        $price  = new Price(
            $amount,
            $currencyCode,
            $tag,
            $group,
            $compositePrices
        );

        $this->assertEquals($amount, $price->getAmount());
        $this->assertEquals($currencyCode, $price->getCurrencyCode());
        $this->assertEquals($tag, $price->getTag());
        $this->assertEquals($group, $price->getGroup());

        $testCompositePrices = $price->getCompositePrices();
        foreach ($testCompositePrices as $testCompositePrice) {
            if (empty($compositePrices[$testCompositePrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testCompositePrice, $compositePrices[$testCompositePrice->getCurrencyCode()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $compositePrice = PriceMock::create();
        $compositePrices = [
            $compositePrice->getCurrencyCode() => $compositePrice,
        ];

        $response = [
            'amount' => MockHelper::getFaker()->randomFloat(),
            'currencyCode' => MockHelper::getFaker()->currencyCode,
            'group' => MockHelper::getFaker()->uuid,
            'tag' => MockHelper::getFaker()->uuid,
            'compositePrices' => \array_map(
                function($price) {
                    /** @var Price $price */
                    return $price->toArray();
                },
                $compositePrices
            )
        ];

        $price = Price::fromResponse($response);

        $this->assertEquals($response['amount'], $price->getAmount());
        $this->assertEquals($response['currencyCode'], $price->getCurrencyCode());
        $this->assertEquals($response['group'], $price->getGroup());
        $this->assertEquals($response['tag'], $price->getTag());

        $testCompositePrices = $price->getCompositePrices();
        foreach ($testCompositePrices as $testCompositePrice) {
            if (empty($compositePrices[$testCompositePrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testCompositePrice, $compositePrices[$testCompositePrice->getCurrencyCode()]);
        }
    }

    /**
     * @return void
     */
    public function testToArray() {
        $compositePrice = PriceMock::create();
        $compositePrices = [
            $compositePrice->getCurrencyCode() => $compositePrice,
        ];

        $price  = new Price(
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            $compositePrices
        );

        $priceArray = $price->toArray();

        $this->assertEquals($price->getAmount(), $priceArray['amount']);
        $this->assertEquals($price->getCurrencyCode(), $priceArray['currencyCode']);
        $this->assertEquals($price->getGroup(), $priceArray['group']);
        $this->assertEquals($price->getTag(), $priceArray['tag']);

        $testCompositePrices = $priceArray['compositePrices'];
        foreach ($testCompositePrices as $testCompositePrice) {
            $testCompositePrice = Price::fromResponse($testCompositePrice);

            if (empty($compositePrices[$testCompositePrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testCompositePrice, $compositePrices[$testCompositePrice->getCurrencyCode()]);
        }
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $price  = new Price(
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                PriceMock::create(),
            ]
        );

        $priceCustomObject = $price->getCustom();

        $this->assertInstanceOf(PriceCustom::class, $priceCustomObject);
    }

}