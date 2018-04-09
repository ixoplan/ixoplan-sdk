<?php

use Ixolit\Dislo\Response\SubscriptionFireEventResponse;
use Ixolit\Dislo\Test\AbstractTestCase;

/**
 * Class SubscriptionFireEventResponseTest
 */
class SubscriptionFireEventResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testFromResponse() {
        $subscriptionFireEventResponse = SubscriptionFireEventResponse::fromResponse([]);

        $this->assertInstanceOf(SubscriptionFireEventResponse::class, $subscriptionFireEventResponse);
    }

}