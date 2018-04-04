<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\BillingMethod;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjectsCustom\BillingEventCustom;

/**
 * Class BillingEventTest
 */
class BillingEventTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingEventId = MockHelper::getFaker()->uuid;
        $userId = MockHelper::getFaker()->uuid;
        $currencyCode = MockHelper::getFaker()->currencyCode;
        $amount = MockHelper::getFaker()->randomFloat();
        $createdAt = MockHelper::getFaker()->dateTime();
        $type = BillingEventMock::randomType();
        $status = BillingEventMock::randomStatus();
        $description = MockHelper::getFaker()->words();
        $techinfo = MockHelper::getFaker()->words;
        $billingMethod = MockHelper::getFaker()->uuid;
        $subscription = SubscriptionMock::create();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $billingMethodObject = BillingMethodMock::create();

        $billingEvent = new BillingEvent(
            $billingEventId,
            $userId,
            $currencyCode,
            $amount,
            $createdAt,
            $type,
            $status,
            $description,
            $techinfo,
            $billingMethod,
            $subscription,
            $modifiedAt,
            $billingMethodObject
        );

        $reflectionObject = new \ReflectionObject($billingEvent);

        $billingEventIdProperty = $reflectionObject->getProperty('billingEventId');
        $billingEventIdProperty->setAccessible(true);
        $this->assertEquals($billingEventId, $billingEventIdProperty->getValue($billingEvent));

        $userIdProperty = $reflectionObject->getProperty('userId');
        $userIdProperty->setAccessible(true);
        $this->assertEquals($userId, $userIdProperty->getValue($billingEvent));

        $currencyCodeProperty = $reflectionObject->getProperty('currencyCode');
        $currencyCodeProperty->setAccessible(true);
        $this->assertEquals($currencyCode, $currencyCodeProperty->getValue($billingEvent));

        $amountProperty = $reflectionObject->getProperty('amount');
        $amountProperty->setAccessible(true);
        $this->assertEquals($amount, $amountProperty->getValue($billingEvent));

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($billingEvent));

        $typeProperty = $reflectionObject->getProperty('type');
        $typeProperty->setAccessible(true);
        $this->assertEquals($type, $typeProperty->getValue($billingEvent));

        $statusProperty = $reflectionObject->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals($status, $statusProperty->getValue($billingEvent));

        $descriptionProperty = $reflectionObject->getProperty('description');
        $descriptionProperty->setAccessible(true);
        $this->assertEquals($description, $descriptionProperty->getValue($billingEvent));

        $techinfoProperty = $reflectionObject->getProperty('techinfo');
        $techinfoProperty->setAccessible(true);
        $this->assertEquals($techinfo, $techinfoProperty->getValue($billingEvent));

        $billingMethodProperty = $reflectionObject->getProperty('billingMethod');
        $billingMethodProperty->setAccessible(true);
        $this->assertEquals($billingMethod, $billingMethodProperty->getValue($billingEvent));

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($billingEvent), $subscription);

        $modifiedAtProperty = $reflectionObject->getProperty('modifiedAt');
        $modifiedAtProperty->setAccessible(true);
        $this->assertEquals($modifiedAt, $modifiedAtProperty->getValue($billingEvent));

        $billingMethodObjectProperty = $reflectionObject->getProperty('billingMethodObject');
        $billingMethodObjectProperty->setAccessible(true);
        $this->compareBillingMethod($billingMethodObjectProperty->getValue($billingEvent), $billingMethodObject);

        //test optional parameters
        new BillingEvent(
            $billingEventId,
            $userId,
            $currencyCode,
            $amount,
            $createdAt,
            $type,
            $status,
            $description,
            $techinfo,
            $billingMethod
        );

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingEventId      = MockHelper::getFaker()->uuid;
        $userId              = MockHelper::getFaker()->uuid;
        $currencyCode        = MockHelper::getFaker()->currencyCode;
        $amount              = MockHelper::getFaker()->randomFloat();
        $createdAt           = MockHelper::getFaker()->dateTime();
        $type                = BillingEventMock::randomType();
        $status              = BillingEventMock::randomStatus();
        $description         = MockHelper::getFaker()->words();
        $techinfo            = MockHelper::getFaker()->words();
        $billingMethod       = MockHelper::getFaker()->uuid;
        $subscription        = SubscriptionMock::create();
        $modifiedAt          = MockHelper::getFaker()->dateTime();
        $billingMethodObject = BillingMethodMock::create();

        $billingEvent = new BillingEvent(
            $billingEventId,
            $userId,
            $currencyCode,
            $amount,
            $createdAt,
            $type,
            $status,
            $description,
            $techinfo,
            $billingMethod,
            $subscription,
            $modifiedAt,
            $billingMethodObject
        );

        $this->assertEquals($billingEventId, $billingEvent->getBillingEventId());
        $this->assertEquals($userId, $billingEvent->getUserId());
        $this->assertEquals($currencyCode, $billingEvent->getCurrencyCode());
        $this->assertEquals($amount, $billingEvent->getAmount());
        $this->assertEquals($createdAt, $billingEvent->getCreatedAt());
        $this->assertEquals($type, $billingEvent->getType());
        $this->assertEquals($status, $billingEvent->getStatus());
        $this->assertEquals($description, $billingEvent->getDescription());
        $this->assertEquals($techinfo, $billingEvent->getTechinfo());
        $this->assertEquals($billingMethod, $billingEvent->getBillingMethod());
        $this->compareSubscription($billingEvent->getSubscription(), $subscription);
        $this->assertEquals($modifiedAt, $billingEvent->getModifiedAt());
        $this->compareBillingMethod($billingEvent->getBillingMethodObject(), $billingMethodObject);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $createdAt = MockHelper::getFaker()->dateTime();
        $modifiedAt = MockHelper::getFaker()->dateTime();
        $subscription = SubscriptionMock::create();
        $billingMethodObject = BillingMethodMock::create();

        $response = [
            'billingEventId'      => MockHelper::getFaker()->uuid,
            'currencyCode'        => MockHelper::getFaker()->currencyCode,
            'userId'              => MockHelper::getFaker()->uuid,
            'amount'              => MockHelper::getFaker()->randomFloat(),
            'createdAt'           => $createdAt->format('Y-m-d H:i:s'),
            'modifiedAt'          => $modifiedAt->format('Y-m-d H:i:s'),
            'type'                => BillingEventMock::randomType(),
            'status'              => BillingEventMock::randomStatus(),
            'description'         => MockHelper::getFaker()->words(),
            'techinfo'            => MockHelper::getFaker()->words(),
            'billingMethod'       => MockHelper::getFaker()->uuid,
            'billingMethodObject' => $billingMethodObject->toArray(),
            'subscription'        => $subscription->toArray(),
        ];

        $billingEvent = BillingEvent::fromResponse($response);

        $this->assertEquals($response['billingEventId'], $billingEvent->getBillingEventId());
        $this->assertEquals($response['userId'], $billingEvent->getUserId());
        $this->assertEquals($response['currencyCode'], $billingEvent->getCurrencyCode());
        $this->assertEquals($response['amount'], $billingEvent->getAmount());
        $this->assertEquals($createdAt, $billingEvent->getCreatedAt());
        $this->assertEquals($response['type'], $billingEvent->getType());
        $this->assertEquals($response['status'], $billingEvent->getStatus());
        $this->assertEquals($response['description'], $billingEvent->getDescription());
        $this->assertEquals($response['techinfo'], $billingEvent->getTechinfo());
        $this->assertEquals($response['billingMethod'], $billingEvent->getBillingMethod());
        $this->compareSubscription($billingEvent->getSubscription(), $subscription);
        $this->assertEquals($modifiedAt, $billingEvent->getModifiedAt());
        $this->compareBillingMethod($billingEvent->getBillingMethodObject(), $billingMethodObject);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $billingEventId      = MockHelper::getFaker()->uuid;
        $userId              = MockHelper::getFaker()->uuid;
        $currencyCode        = MockHelper::getFaker()->currencyCode;
        $amount              = MockHelper::getFaker()->randomFloat();
        $createdAt           = MockHelper::getFaker()->dateTime();
        $type                = BillingEventMock::randomType();
        $status              = BillingEventMock::randomStatus();
        $description         = MockHelper::getFaker()->words();
        $techinfo            = MockHelper::getFaker()->words();
        $billingMethod       = MockHelper::getFaker()->uuid;
        $subscription        = SubscriptionMock::create();
        $modifiedAt          = MockHelper::getFaker()->dateTime();
        $billingMethodObject = BillingMethodMock::create();

        $billingEvent = new BillingEvent(
            $billingEventId,
            $userId,
            $currencyCode,
            $amount,
            $createdAt,
            $type,
            $status,
            $description,
            $techinfo,
            $billingMethod,
            $subscription,
            $modifiedAt,
            $billingMethodObject
        );

        $billingEventArray = $billingEvent->toArray();

        $this->assertEquals($billingEventId, $billingEventArray['billingEventId']);
        $this->assertEquals($userId, $billingEventArray['userId']);
        $this->assertEquals($currencyCode, $billingEventArray['currencyCode']);
        $this->assertEquals($amount, $billingEventArray['amount']);
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $billingEventArray['createdAt']);
        $this->assertEquals($type, $billingEventArray['type']);
        $this->assertEquals($status, $billingEventArray['status']);
        $this->assertEquals($description, $billingEventArray['description']);
        $this->assertEquals($techinfo, $billingEventArray['techinfo']);
        $this->assertEquals($billingMethod, $billingEventArray['billingMethod']);
        $this->compareSubscription(Subscription::fromResponse($billingEventArray['subscription']), $subscription);
        $this->assertEquals($modifiedAt->format('Y-m-d H:i:s'), $billingEventArray['modifiedAt']);
        $this->compareBillingMethod(BillingMethod::fromResponse($billingEventArray['billingMethodObject']), $billingMethodObject);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $billingEvent = new BillingEvent(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->currencyCode,
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->dateTime(),
            BillingEventMock::randomType(),
            BillingEventMock::randomStatus(),
            MockHelper::getFaker()->words(),
            MockHelper::getFaker()->words(),
            MockHelper::getFaker()->uuid,
            SubscriptionMock::create(),
            MockHelper::getFaker()->dateTime(),
            BillingMethodMock::create()
        );

        $billingEventCustomObject = $billingEvent->getCustom();

        $this->assertInstanceOf(BillingEventCustom::class, $billingEventCustomObject);
    }

}