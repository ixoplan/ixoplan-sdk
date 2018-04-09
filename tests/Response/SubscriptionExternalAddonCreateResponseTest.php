<?php

use Ixolit\Dislo\Response\SubscriptionExternalAddonCreateResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;

/**
 * Class SubscriptionExternalAddonCreateResponseTest
 */
class SubscriptionExternalAddonCreateResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $subscription = SubscriptionMock::create();
        $upgradeId = MockHelper::getFaker()->numberBetween();

        $subscriptionExternalAddonCreateResponse = new SubscriptionExternalAddonCreateResponse(
            $subscription,
            $upgradeId
        );

        $reflectionObject = new \ReflectionObject($subscriptionExternalAddonCreateResponse);

        $subscriptionProperty = $reflectionObject->getProperty('subscription');
        $subscriptionProperty->setAccessible(true);
        $this->compareSubscription($subscriptionProperty->getValue($subscriptionExternalAddonCreateResponse), $subscription);

        $upgradeIdProperty = $reflectionObject->getProperty('upgradeId');
        $upgradeIdProperty->setAccessible(true);
        $this->assertEquals($upgradeId, $upgradeIdProperty->getValue($subscriptionExternalAddonCreateResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $subscription = SubscriptionMock::create();
        $upgradeId = MockHelper::getFaker()->numberBetween();

        $subscriptionExternalAddonCreateResponse = new SubscriptionExternalAddonCreateResponse(
            $subscription,
            $upgradeId
        );

        $this->compareSubscription($subscriptionExternalAddonCreateResponse->getSubscription(), $subscription);
        $this->assertEquals($upgradeId, $subscriptionExternalAddonCreateResponse->getUpgradeId());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscription = SubscriptionMock::create();

        $response = [
            'subscription' => $subscription->toArray(),
            'upgradeId'    => MockHelper::getFaker()->numberBetween(),
        ];

        $subscriptionExternalAddonCreateResponse = SubscriptionExternalAddonCreateResponse::fromResponse($response);


        $this->compareSubscription($subscriptionExternalAddonCreateResponse->getSubscription(), $subscription);
        $this->assertEquals($response['upgradeId'], $subscriptionExternalAddonCreateResponse->getUpgradeId());
    }

}