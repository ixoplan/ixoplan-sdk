<?php

use Ixolit\Dislo\Response\BillingExternalCreateChargeResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class BillingExternalCreateChargeResponseTest
 */
class BillingExternalCreateChargeResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingEventId = MockHelper::getFaker()->numberBetween();

        $billingExternalCreateChargeResponse = new BillingExternalCreateChargeResponse($billingEventId);

        $reflectionObject = new \ReflectionObject($billingExternalCreateChargeResponse);

        $billingEventIdProperty = $reflectionObject->getProperty('billingEventId');
        $billingEventIdProperty->setAccessible(true);
        $this->assertEquals($billingEventId, $billingEventIdProperty->getValue($billingExternalCreateChargeResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingEventId = MockHelper::getFaker()->numberBetween();

        $billingExternalCreateChargeResponse = new BillingExternalCreateChargeResponse($billingEventId);

        $this->assertEquals($billingEventId, $billingExternalCreateChargeResponse->getBillingEventId());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'billingEventId' => MockHelper::getFaker()->randomNumber(),
        ];

        $billingExternalCreateChargeResponse = BillingExternalCreateChargeResponse::fromResponse($response);

        $this->assertEquals($response['billingEventId'], $billingExternalCreateChargeResponse->getBillingEventId());
    }

}