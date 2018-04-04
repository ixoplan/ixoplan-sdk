<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\BillingMethod;
use Ixolit\Dislo\WorkingObjectsCustom\BillingMethodCustom;

/**
 * Class BillingMethodTest
 */
class BillingMethodTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingMethodId = MockHelper::getFaker()->uuid;
        $name            = MockHelper::getFaker()->uuid;
        $displayName     = MockHelper::getFaker()->word;
        $available       = MockHelper::getFaker()->boolean();
        $checkout        = MockHelper::getFaker()->boolean();
        $flexible        = MockHelper::getFaker()->boolean();
        $recurring       = MockHelper::getFaker()->boolean();
        $replaceable     = MockHelper::getFaker()->boolean();

        $billingMethod = new BillingMethod(
            $billingMethodId,
            $name,
            $displayName,
            $available,
            $checkout,
            $flexible,
            $recurring,
            $replaceable
        );

        $reflectionObject = new \ReflectionObject($billingMethod);

        $billingMethodIdProperty = $reflectionObject->getProperty('billingMethodId');
        $billingMethodIdProperty->setAccessible(true);
        $this->assertEquals($billingMethodId, $billingMethodIdProperty->getValue($billingMethod));

        $nameProperty = $reflectionObject->getProperty('name');
        $nameProperty->setAccessible(true);
        $this->assertEquals($name, $nameProperty->getValue($billingMethod));

        $displayNameProperty = $reflectionObject->getProperty('displayName');
        $displayNameProperty->setAccessible(true);
        $this->assertEquals($displayName, $displayNameProperty->getValue($billingMethod));

        $availableProperty = $reflectionObject->getProperty('available');
        $availableProperty->setAccessible(true);
        $this->assertEquals($available, $availableProperty->getValue($billingMethod));

        $checkoutProperty = $reflectionObject->getProperty('checkout');
        $checkoutProperty->setAccessible(true);
        $this->assertEquals($checkout, $checkoutProperty->getValue($billingMethod));

        $flexibleProperty = $reflectionObject->getProperty('flexible');
        $flexibleProperty->setAccessible(true);
        $this->assertEquals($flexible, $flexibleProperty->getValue($billingMethod));

        $recurringProperty = $reflectionObject->getProperty('recurring');
        $recurringProperty->setAccessible(true);
        $this->assertEquals($recurring, $recurringProperty->getValue($billingMethod));

        $replaceableProperty = $reflectionObject->getProperty('replaceable');
        $replaceableProperty->setAccessible(true);
        $this->assertEquals($replaceable, $replaceableProperty->getValue($billingMethod));

        //test without optional parameters

        new BillingMethod(
            $billingMethodId,
            $name,
            $displayName
        );

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingMethodId = MockHelper::getFaker()->uuid;
        $name            = MockHelper::getFaker()->uuid;
        $displayName     = MockHelper::getFaker()->word;
        $available       = MockHelper::getFaker()->boolean();
        $checkout        = MockHelper::getFaker()->boolean();
        $flexible        = MockHelper::getFaker()->boolean();
        $recurring       = MockHelper::getFaker()->boolean();
        $replaceable     = MockHelper::getFaker()->boolean();

        $billingMethod = new BillingMethod(
            $billingMethodId,
            $name,
            $displayName,
            $available,
            $checkout,
            $flexible,
            $recurring,
            $replaceable
        );

        $this->assertEquals($billingMethodId, $billingMethod->getBillingMethodId());
        $this->assertEquals($name, $billingMethod->getName());
        $this->assertEquals($displayName, $billingMethod->getDisplayName());
        $this->assertEquals($available, $billingMethod->isAvailable());
        $this->assertEquals($checkout, $billingMethod->isCheckout());
        $this->assertEquals($flexible, $billingMethod->isFlexible());
        $this->assertEquals($recurring, $billingMethod->isRecurring());
        $this->assertEquals($replaceable, $billingMethod->isReplaceable());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'billingMethodId' => MockHelper::getFaker()->uuid,
            'name'            => MockHelper::getFaker()->uuid,
            'displayName'     => MockHelper::getFaker()->word,
            'available'       => MockHelper::getFaker()->boolean(),
            'checkout'        => MockHelper::getFaker()->boolean(),
            'flexible'        => MockHelper::getFaker()->boolean(),
            'recurring'       => MockHelper::getFaker()->boolean(),
            'replaceable'     => MockHelper::getFaker()->boolean(),
        ];

        $billingMethod = BillingMethod::fromResponse($response);

        $this->assertEquals($response['billingMethodId'], $billingMethod->getBillingMethodId());
        $this->assertEquals($response['name'], $billingMethod->getName());
        $this->assertEquals($response['displayName'], $billingMethod->getDisplayName());
        $this->assertEquals($response['available'], $billingMethod->isAvailable());
        $this->assertEquals($response['checkout'], $billingMethod->isCheckout());
        $this->assertEquals($response['flexible'], $billingMethod->isFlexible());
        $this->assertEquals($response['recurring'], $billingMethod->isRecurring());
        $this->assertEquals($response['replaceable'], $billingMethod->isReplaceable());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $billingMethod = new BillingMethod(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );

        $billingMethodArray = $billingMethod->toArray();

        $this->assertEquals($billingMethod->getBillingMethodId(), $billingMethodArray['billingMethodId']);
        $this->assertEquals($billingMethod->getName(), $billingMethodArray['name']);
        $this->assertEquals($billingMethod->getDisplayName(), $billingMethodArray['displayName']);
        $this->assertEquals($billingMethod->isAvailable(), $billingMethodArray['available']);
        $this->assertEquals($billingMethod->isCheckout(), $billingMethodArray['checkout']);
        $this->assertEquals($billingMethod->isFlexible(), $billingMethodArray['flexible']);
        $this->assertEquals($billingMethod->isRecurring(), $billingMethodArray['recurring']);
        $this->assertEquals($billingMethod->isReplaceable(), $billingMethodArray['replaceable']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $billingMethod = new BillingMethod(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->word,
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->boolean()
        );

        $billingMethodCustomObject = $billingMethod->getCustom();

        $this->assertInstanceOf(BillingMethodCustom::class, $billingMethodCustomObject);
    }

}