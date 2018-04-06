<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;
use Ixolit\Dislo\WorkingObjects\PackagePeriod;
use Ixolit\Dislo\WorkingObjects\Price;
use Ixolit\Dislo\WorkingObjectsCustom\PackagePeriodCustom;

/**
 * Class PackagePeriodTest
 */
class PackagePeriodTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $length = MockHelper::getFaker()->numberBetween();
        $lengthUnit = MockHelper::getFaker()->word;
        $metaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];

        $price = PriceMock::create();
        $basePrice = [
            $price->getCurrencyCode() => $price,
        ];

        $minimumTermLength = MockHelper::getFaker()->numberBetween();

        $packagePeriod = new PackagePeriod(
            $length,
            $lengthUnit,
            $metaData,
            $basePrice,
            $minimumTermLength
        );

        $reflectionObject = new \ReflectionObject($packagePeriod);

        $lengthProperty = $reflectionObject->getProperty('length');
        $lengthProperty->setAccessible(true);
        $this->assertEquals($length, $lengthProperty->getValue($packagePeriod));

        $lengthUnitProperty = $reflectionObject->getProperty('lengthUnit');
        $lengthUnitProperty->setAccessible(true);
        $this->assertEquals($lengthUnit, $lengthUnitProperty->getValue($packagePeriod));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($packagePeriod));

        $basePriceProperty = $reflectionObject->getProperty('basePrice');
        $basePriceProperty->setAccessible(true);

        /** @var Price[] $testBasePrice */
        $testBasePrice = $basePriceProperty->getValue($packagePeriod);
        foreach ($testBasePrice as $testPrice) {
            if (empty($basePrice[$testPrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testPrice, $basePrice[$testPrice->getCurrencyCode()]);
        }

        $this->assertEquals($length, $lengthProperty->getValue($packagePeriod));

        $minimumTerLengthProperty = $reflectionObject->getProperty('minimumTermLength');
        $minimumTerLengthProperty->setAccessible(true);
        $this->assertEquals($minimumTermLength, $minimumTerLengthProperty->getValue($packagePeriod));

        new PackagePeriod(
            $length,
            $lengthUnit
        );

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $length = MockHelper::getFaker()->numberBetween();
        $lengthUnit = MockHelper::getFaker()->word;
        $metaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];

        $price = PriceMock::create();
        $basePrice = [
            $price->getCurrencyCode() => $price,
        ];

        $minimumTermLength = MockHelper::getFaker()->numberBetween();

        $packagePeriod = new PackagePeriod(
            $length,
            $lengthUnit,
            $metaData,
            $basePrice,
            $minimumTermLength
        );

        $this->assertEquals($length, $packagePeriod->getLength());
        $this->assertEquals($lengthUnit, $packagePeriod->getLengthUnit());
        $this->assertEquals($metaData, $packagePeriod->getMetaData());

        $testBasePrice = $packagePeriod->getBasePrice();
        foreach ($testBasePrice as $testPrice) {
            if (empty($basePrice[$testPrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testPrice, $basePrice[$testPrice->getCurrencyCode()]);
        }

        $this->assertEquals($minimumTermLength, $packagePeriod->getMinimumTermLength());

        $this->comparePrice($price, $packagePeriod->getBasePriceForCurrency($price->getCurrencyCode()));

        $this->assertEquals(($price->getAmount() > 0), $packagePeriod->isPaid());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $price = PriceMock::create();
        $basePrice = [
            $price->getCurrencyCode() => $price,
        ];

        $response = [
            'metaData'          => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'length'            => MockHelper::getFaker()->numberBetween(),
            'lengthUnit'        => MockHelper::getFaker()->word,
            'basePrice'         => \array_map(
                function($price) {
                    /** @var Price $price */
                    return $price->toArray();
                },
                $basePrice
            ),
            'minimumTermLength' => MockHelper::getFaker()->numberBetween(),
        ];

        $packagePeriod = PackagePeriod::fromResponse($response);

        $this->assertEquals($response['length'], $packagePeriod->getLength());
        $this->assertEquals($response['lengthUnit'], $packagePeriod->getLengthUnit());
        $this->assertEquals($response['metaData'], $packagePeriod->getMetaData());

        $testBasePrice = $packagePeriod->getBasePrice();
        foreach ($testBasePrice as $testPrice) {
            if (empty($basePrice[$testPrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testPrice, $basePrice[$testPrice->getCurrencyCode()]);
        }

        $this->assertEquals($response['minimumTermLength'], $packagePeriod->getMinimumTermLength());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $price = PriceMock::create();
        $basePrice = [
            $price->getCurrencyCode() => $price,
        ];

        $packagePeriod = new PackagePeriod(
            MockHelper::getFaker()->numberBetween(),
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            $basePrice,
            MockHelper::getFaker()->numberBetween()
        );

        $packagePeriodArray = $packagePeriod->toArray();

        $this->assertEquals($packagePeriod->getLength(), $packagePeriodArray['length']);
        $this->assertEquals($packagePeriod->getLengthUnit(), $packagePeriodArray['lengthUnit']);
        $this->assertEquals($packagePeriod->getMetaData(), $packagePeriodArray['metaData']);

        $testBasePrice = $packagePeriodArray['basePrice'];
        foreach ($testBasePrice as $testPrice) {
            $testPrice = Price::fromResponse($testPrice);

            if (empty($basePrice[$testPrice->getCurrencyCode()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePrice($testPrice, $basePrice[$testPrice->getCurrencyCode()]);
        }

        $this->assertEquals($packagePeriod->getMinimumTermLength(), $packagePeriodArray['minimumTermLength']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $packagePeriod = new PackagePeriod(
            MockHelper::getFaker()->numberBetween(),
            MockHelper::getFaker()->word,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            [
                PriceMock::create(),
            ],
            MockHelper::getFaker()->numberBetween()
        );

        $packagePeriodCustomObject = $packagePeriod->getCustom();

        $this->assertInstanceOf(PackagePeriodCustom::class, $packagePeriodCustomObject);
    }

}