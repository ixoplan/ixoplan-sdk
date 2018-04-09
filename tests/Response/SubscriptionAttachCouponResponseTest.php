<?php

use Ixolit\Dislo\Response\SubscriptionAttachCouponResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class SubscriptionAttachCouponResponseTest
 */
class SubscriptionAttachCouponResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $attached = MockHelper::getFaker()->boolean();
        $reason = MockHelper::getFaker()->word;

        $subscriptionAttachCouponResponse = new SubscriptionAttachCouponResponse($attached, $reason);

        $reflectionObject = new \ReflectionObject($subscriptionAttachCouponResponse);

        $attachedProperty = $reflectionObject->getProperty('attached');
        $attachedProperty->setAccessible(true);
        $this->assertEquals($attached, $attachedProperty->getValue($subscriptionAttachCouponResponse));

        $reasonProperty = $reflectionObject->getProperty('reason');
        $reasonProperty->setAccessible(true);
        $this->assertEquals($reason, $reasonProperty->getValue($subscriptionAttachCouponResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $attached = MockHelper::getFaker()->boolean();
        $reason = MockHelper::getFaker()->word;

        $subscriptionAttachCouponResponse = new SubscriptionAttachCouponResponse($attached, $reason);

        $this->assertEquals($attached, $subscriptionAttachCouponResponse->getAttached());
        $this->assertEquals($reason, $subscriptionAttachCouponResponse->getReason());
    }

    /**
     * @return void
     */
    public function testResponse() {
        $response = [
            'attached' => MockHelper::getFaker()->boolean(),
            'reason'   => MockHelper::getFaker()->word,
        ];

        $subscriptionAttachCouponResponse = SubscriptionAttachCouponResponse::fromResponse($response);

        $this->assertEquals($response['attached'], $subscriptionAttachCouponResponse->getAttached());
        $this->assertEquals($response['reason'], $subscriptionAttachCouponResponse->getReason());
    }

}