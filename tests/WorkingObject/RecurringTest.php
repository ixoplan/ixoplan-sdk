<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\RecurringMock;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\BillingMethod;
use Ixolit\Dislo\WorkingObjects\Recurring;
use Ixolit\Dislo\WorkingObjects\Subscription;
use Ixolit\Dislo\WorkingObjectsCustom\RecurringCustom;

/**
 * Class RecurringTest
 */
class RecurringTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $recurringId   = MockHelper::getFaker()->uuid;
        $status        = RecurringMock::randomStatus();
        $providerToken = MockHelper::getFaker()->uuid;
        $subscription  = SubscriptionMock::create();
        $createdAt     = MockHelper::getFaker()->dateTime();
        $canceledAt    = MockHelper::getFaker()->dateTime();
        $closedAt      = MockHelper::getFaker()->dateTime();
        $parameters    = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $amount        = MockHelper::getFaker()->randomFloat();
        $currency      = MockHelper::getFaker()->currencyCode;
        $billingMethod = BillingMethodMock::create();

        $recurring = new Recurring(
            $recurringId,
            $status,
            $providerToken,
            $subscription,
            $createdAt,
            $canceledAt,
            $closedAt,
            $parameters,
            $amount,
            $currency,
            $billingMethod
        );

        $reflectionObject = new \ReflectionObject($recurring);

        $recurringIdProperty = $reflectionObject->getProperty('recurringId');
        $recurringIdProperty->setAccessible(true);
        $this->assertEquals($recurringId, $recurringIdProperty->getValue($recurring));

        $statusProperty = $reflectionObject->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals($status, $statusProperty->getValue($recurring));

        $providerTokenProperty = $reflectionObject->getProperty('providerToken');
        $providerTokenProperty->setAccessible(true);
        $this->assertEquals($providerToken, $providerTokenProperty->getValue($recurring));

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($recurring), $subscription);

        $createdAtProperty = $reflectionObject->getProperty('createdAt');
        $createdAtProperty->setAccessible(true);
        $this->assertEquals($createdAt, $createdAtProperty->getValue($recurring));

        $canceledAtProperty = $reflectionObject->getProperty('canceledAt');
        $canceledAtProperty->setAccessible(true);
        $this->assertEquals($canceledAt, $canceledAtProperty->getValue($recurring));

        $closedAtProperty = $reflectionObject->getProperty('closedAt');
        $closedAtProperty->setAccessible(true);
        $this->assertEquals($closedAt, $closedAtProperty->getValue($recurring));

        $parametersProperty = $reflectionObject->getProperty('parameters');
        $parametersProperty->setAccessible(true);
        $this->assertEquals($parameters, $parametersProperty->getValue($recurring));

        $amountProperty = $reflectionObject->getProperty('amount');
        $amountProperty->setAccessible(true);
        $this->assertEquals($amount, $amountProperty->getValue($recurring));

        $currencyProperty = $reflectionObject->getProperty('currency');
        $currencyProperty->setAccessible(true);
        $this->assertEquals($currency, $currencyProperty->getValue($recurring));

        $billingMethodProperty = $reflectionObject->getProperty('billingMethod');
        $billingMethodProperty->setAccessible(true);
        $this->compareBillingMethod($billingMethodProperty->getValue($recurring), $billingMethod);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $recurringId   = MockHelper::getFaker()->uuid;
        $status        = RecurringMock::randomStatus();
        $providerToken = MockHelper::getFaker()->uuid;
        $subscription  = SubscriptionMock::create();
        $createdAt     = MockHelper::getFaker()->dateTime();
        $canceledAt    = MockHelper::getFaker()->dateTime();
        $closedAt      = MockHelper::getFaker()->dateTime();
        $parameters    = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $amount        = MockHelper::getFaker()->randomFloat();
        $currency      = MockHelper::getFaker()->currencyCode;
        $billingMethod = BillingMethodMock::create();

        $recurring = new Recurring(
            $recurringId,
            $status,
            $providerToken,
            $subscription,
            $createdAt,
            $canceledAt,
            $closedAt,
            $parameters,
            $amount,
            $currency,
            $billingMethod
        );

        $this->assertEquals($recurringId, $recurring->getRecurringId());
        $this->assertEquals($status, $recurring->getStatus());
        $this->assertEquals($providerToken, $recurring->getProviderToken());
        $this->compareSubscription($recurring->getSubscription(), $subscription);
        $this->assertEquals($createdAt, $recurring->getCreatedAt());
        $this->assertEquals($canceledAt, $recurring->getCanceledAt());
        $this->assertEquals($closedAt, $recurring->getClosedAt());
        $this->assertEquals($parameters, $recurring->getParameters());
        $this->assertEquals($amount, $recurring->getAmount());
        $this->assertEquals($currency, $recurring->getCurrency());
        $this->compareBillingMethod($recurring->getBillingMethod(), $billingMethod);
    }

    public function testFromResponse() {
        $subscription  = SubscriptionMock::create();
        $createdAt     = MockHelper::getFaker()->dateTime();
        $canceledAt    = MockHelper::getFaker()->dateTime();
        $closedAt      = MockHelper::getFaker()->dateTime();
        $billingMethod = BillingMethodMock::create();

        $response = [
            'recurringId'   => MockHelper::getFaker()->uuid,
            'status'        => RecurringMock::randomStatus(),
            'providerToken' => MockHelper::getFaker()->uuid,
            'subscription'  => $subscription->toArray(),
            'createdAt'     => $createdAt->format('Y-m-d H:i:s'),
            'canceledAt'    => $canceledAt->format('Y-m-d H:i:s'),
            'closedAt'      => $closedAt->format('Y-m-d H:i:s'),
            'parameters'    => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'amount'        => MockHelper::getFaker()->randomFloat(),
            'currency'      => MockHelper::getFaker()->currencyCode,
            'billingMethod' => $billingMethod->toArray(),
        ];

        $recurring = Recurring::fromResponse($response);

        $this->assertEquals($response['recurringId'], $recurring->getRecurringId());
        $this->assertEquals($response['status'], $recurring->getStatus());
        $this->assertEquals($response['providerToken'], $recurring->getProviderToken());
        $this->compareSubscription($recurring->getSubscription(), $subscription);
        $this->assertEquals($createdAt, $recurring->getCreatedAt());
        $this->assertEquals($canceledAt, $recurring->getCanceledAt());
        $this->assertEquals($closedAt, $recurring->getClosedAt());
        $this->assertEquals($response['parameters'], $recurring->getParameters());
        $this->assertEquals($response['amount'], $recurring->getAmount());
        $this->assertEquals($response['currency'], $recurring->getCurrency());
        $this->compareBillingMethod($recurring->getBillingMethod(), $billingMethod);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $subscription  = SubscriptionMock::create();
        $createdAt     = MockHelper::getFaker()->dateTime();
        $canceledAt    = MockHelper::getFaker()->dateTime();
        $closedAt      = MockHelper::getFaker()->dateTime();
        $billingMethod = BillingMethodMock::create();

        $recurring = new Recurring(
            MockHelper::getFaker()->uuid,
            RecurringMock::randomStatus(),
            MockHelper::getFaker()->uuid,
            $subscription,
            $createdAt,
            $canceledAt,
            $closedAt,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->currencyCode,
            $billingMethod
        );

        $recurringArray = $recurring->toArray();

        $this->assertEquals($recurring->getRecurringId(), $recurringArray['recurringId']);
        $this->assertEquals($recurring->getStatus(), $recurringArray['status']);
        $this->assertEquals($recurring->getProviderToken(), $recurringArray['providerToken']);
        $this->compareSubscription(Subscription::fromResponse($recurringArray['subscription']), $recurring->getSubscription());
        $this->assertEquals($createdAt->format('Y-m-d H:i:s'), $recurringArray['createdAt']);
        $this->assertEquals($canceledAt->format('Y-m-d H:i:s'), $recurringArray['canceledAt']);
        $this->assertEquals($closedAt->format('Y-m-d H:i:s'), $recurringArray['closedAt']);
        $this->assertEquals($recurring->getParameters(), $recurringArray['parameters']);
        $this->assertEquals($recurring->getAmount(), $recurringArray['amount']);
        $this->assertEquals($recurring->getCurrency(), $recurringArray['currency']);
        $this->compareBillingMethod(BillingMethod::fromResponse($recurringArray['billingMethod']), $billingMethod);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $recurring = new Recurring(
            MockHelper::getFaker()->uuid,
            RecurringMock::randomStatus(),
            MockHelper::getFaker()->uuid,
            SubscriptionMock::create(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            MockHelper::getFaker()->randomFloat(),
            MockHelper::getFaker()->currencyCode,
            BillingMethodMock::create()
        );

        $recurringCustomObject = $recurring->getCustom();

        $this->assertInstanceOf(RecurringCustom::class, $recurringCustomObject);
    }

}