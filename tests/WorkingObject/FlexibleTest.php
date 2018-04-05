<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjectsCustom\FlexibleCustom;

/**
 * Class FlexibleTest
 */
class FlexibleTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstruct() {
        $flexibleId          = MockHelper::getFaker()->uuid;
        $status              = FlexibleMock::randomStatus();
        $metaData            = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $createdAt           = MockHelper::getFaker()->dateTime();
        $billingMethod       = MockHelper::getFaker()->uuid;
        $billingMethodObject = BillingMethodMock::create();

        $flexible = new Flexible(
            $flexibleId,
            $status,
            $metaData,
            $createdAt,
            $billingMethod,
            $billingMethodObject
        );

        $reflectionObject = new \ReflectionObject($flexible);

        $flexibleIdProperty = $reflectionObject->getProperty('flexibleId');
        $flexibleIdProperty->setAccessible(true);
        $this->assertEquals($flexibleId, $flexibleIdProperty->getValue($flexible));

        $statusProperty = $reflectionObject->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals($status, $statusProperty->getValue($flexible));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($flexible));

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($flexible));

        $billingMethodProperty = $reflectionObject->getProperty('billingMethod');
        $billingMethodProperty->setAccessible(true);
        $this->assertEquals($billingMethod, $billingMethodProperty->getValue($flexible));

        $billingMethodObjectProperty = $reflectionObject->getProperty('billingMethodObject');
        $billingMethodObjectProperty->setAccessible(true);
        $this->assertEquals($billingMethodObject, $billingMethodObjectProperty->getValue($flexible));

        new Flexible(
            $flexibleId,
            $status,
            $metaData,
            $createdAt,
            $billingMethod
        );

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testGetters() {

        $flexibleId          = MockHelper::getFaker()->uuid;
        $status              = FlexibleMock::randomStatus();
        $metaData            = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $createdAt           = MockHelper::getFaker()->dateTime();
        $billingMethod       = MockHelper::getFaker()->uuid;
        $billingMethodObject = BillingMethodMock::create();

        $flexible = new Flexible(
            $flexibleId,
            $status,
            $metaData,
            $createdAt,
            $billingMethod,
            $billingMethodObject
        );

        $this->assertEquals($flexibleId, $flexible->getFlexibleId());
        $this->assertEquals($status, $flexible->getStatus());
        $this->assertEquals($metaData, $flexible->getMetaData());
        $this->assertEquals($createdAt, $flexible->getCreatedAt());
        $this->assertEquals($billingMethod, $flexible->getBillingMethod());
        $this->compareBillingMethod($flexible->getBillingMethodObject(), $billingMethodObject);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $createdAt = MockHelper::getFaker()->dateTime();
        $billingMethodObject = BillingMethodMock::create();

        $response = [
            'flexibleId'          => MockHelper::getFaker()->uuid,
            'status'              => FlexibleMock::randomStatus(),
            'metaData'            => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'createdAt'           => $createdAt->format('Y-m-d H:i:s'),
            'billingMethod'       => MockHelper::getFaker()->uuid,
            'billingMethodObject' => $billingMethodObject->toArray(),
        ];

        $flexible = Flexible::fromResponse($response);

        $this->assertEquals($response['flexibleId'], $flexible->getFlexibleId());
        $this->assertEquals($response['status'], $flexible->getStatus());
        $this->assertEquals($response['metaData'], $flexible->getMetaData());
        $this->assertEquals($createdAt, $flexible->getCreatedAt());
        $this->assertEquals($response['billingMethod'], $flexible->getBillingMethod());
        $this->compareBillingMethod($flexible->getBillingMethodObject(), $billingMethodObject);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $createdAt = MockHelper::getFaker()->dateTime();
        $billingMethodObject = BillingMethodMock::create();

        $flexible = new Flexible(
            MockHelper::getFaker()->uuid,
            FlexibleMock::randomStatus(),
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            $createdAt,
            MockHelper::getFaker()->uuid,
            $billingMethodObject
        );

        $flexibleArray = $flexible->toArray();

        $this->assertEquals($flexible->getFlexibleId(), $flexibleArray['flexibleId']);
        $this->assertEquals($flexible->getStatus(), $flexibleArray['status']);
        $this->assertEquals($flexible->getMetaData(), $flexibleArray['metaData']);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $flexibleArray['createdAt']);
        $this->assertEquals($flexible->getBillingMethod(), $flexibleArray['billingMethod']);
        $this->assertEquals($billingMethodObject->toArray(), $flexibleArray['billingMethodObject']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $flexible = new Flexible(
            MockHelper::getFaker()->uuid,
            FlexibleMock::randomStatus(),
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->uuid,
            BillingMethodMock::create()
        );

        $flexibleCustomObject = $flexible->getCustom();

        $this->assertInstanceOf(FlexibleCustom::class, $flexibleCustomObject);
    }

}