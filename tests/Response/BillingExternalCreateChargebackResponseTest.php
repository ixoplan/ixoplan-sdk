<?php

use Ixolit\Dislo\Response\BillingExternalCreateChargebackResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Created by PhpStorm.
 * User: dschobert
 * Date: 09.04.18
 * Time: 14:15
 */
class BillingExternalCreateChargebackResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingEventId = MockHelper::getFaker()->numberBetween();

        $billingExternalCreateChargebackResponse = new BillingExternalCreateChargebackResponse($billingEventId);

        $reflectionObject = new \ReflectionObject($billingExternalCreateChargebackResponse);

        $billingEventIdProperty = $reflectionObject->getProperty('billingEventId');
        $billingEventIdProperty->setAccessible(true);
        $this->assertEquals($billingEventId, $billingEventIdProperty->getValue($billingExternalCreateChargebackResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingEventId = MockHelper::getFaker()->numberBetween();

        $billingExternalCreateChargebackResponse = new BillingExternalCreateChargebackResponse($billingEventId);

        $this->assertEquals($billingEventId, $billingExternalCreateChargebackResponse->getBillingEventId());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $response = [
            'billingEventId' => MockHelper::getFaker()->randomNumber(),
        ];

        $billingExternalCreateChargebackResponse = BillingExternalCreateChargebackResponse::fromResponse($response);

        $this->assertEquals($response['billingEventId'], $billingExternalCreateChargebackResponse->getBillingEventId());
    }

}