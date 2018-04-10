<?php

use Ixolit\Dislo\Response\UserGetSignupStatusResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\Test\WorkingObjects\UserMock;

/**
 * Class UserGetSignupStatusResponseTest
 */
class UserGetSignupStatusResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $status = MockHelper::getFaker()->word;
        $user = UserMock::create();
        $subscription = SubscriptionMock::create();
        $billingEvent = BillingEventMock::create();

        $userGetSignupStatusResponse = new UserGetSignupStatusResponse(
            $status,
            $user,
            $subscription,
            $billingEvent
        );

        $reflectionObject = new \ReflectionObject($userGetSignupStatusResponse);

        $statusProperty = $reflectionObject->getProperty('status');
        $statusProperty->setAccessible(true);
        $this->assertEquals($status, $statusProperty->getValue($userGetSignupStatusResponse));

        $userProperty = $reflectionObject->getProperty('user');
        $userProperty->setAccessible(true);
        $this->compareUser($userProperty->getValue($userGetSignupStatusResponse), $user);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($userGetSignupStatusResponse), $subscription);

        $billingEventProperty = $reflectionObject->getProperty('billingEvent');
        $billingEventProperty->setAccessible(true);
        $this->compareBillingEvent($billingEventProperty->getValue($userGetSignupStatusResponse), $billingEvent);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $status = MockHelper::getFaker()->word;
        $user = UserMock::create();
        $subscription = SubscriptionMock::create();
        $billingEvent = BillingEventMock::create();

        $userGetSignupStatusResponse = new UserGetSignupStatusResponse(
            $status,
            $user,
            $subscription,
            $billingEvent
        );

        $this->assertEquals($status, $userGetSignupStatusResponse->getStatus());
        $this->compareUser($userGetSignupStatusResponse->getUser(), $user);
        $this->compareSubscription($userGetSignupStatusResponse->getSubscription(), $subscription);
        $this->compareBillingEvent($userGetSignupStatusResponse->getBillingEvent(), $billingEvent);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $user = UserMock::create();
        $subscription = SubscriptionMock::create();
        $billingEvent = BillingEventMock::create();

        $response = [
            'status' => MockHelper::getFaker()->word,
            'user'   => $user->toArray(),
            'subscription' => $subscription->toArray(),
            'billingEvent' => $billingEvent->toArray(),
        ];

        $userGetSignupStatusResponse = UserGetSignupStatusResponse::fromResponse($response);

        $this->assertEquals($response['status'], $userGetSignupStatusResponse->getStatus());
        $this->compareUser($userGetSignupStatusResponse->getUser(), $user);
        $this->compareSubscription($userGetSignupStatusResponse->getSubscription(), $subscription);
        $this->compareBillingEvent($userGetSignupStatusResponse->getBillingEvent(), $billingEvent);
    }

}