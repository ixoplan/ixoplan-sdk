<?php

use Ixolit\Dislo\Response\BillingGetEventResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;

/**
 * Class BillingGetEventResponseTest
 */
class BillingGetEventResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingEvent = BillingEventMock::create();

        $billingGetEventResponse = new BillingGetEventResponse($billingEvent);

        $reflectionObject = new \ReflectionObject($billingGetEventResponse);

        $billingEventProperty = $reflectionObject->getProperty('billingEvent');
        $billingEventProperty->setAccessible(true);
        $this->compareBillingEvent($billingEventProperty->getValue($billingGetEventResponse), $billingEvent);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingEvent = BillingEventMock::create();

        $billingGetEventResponse = new BillingGetEventResponse($billingEvent);

        $this->compareBillingEvent($billingGetEventResponse->getBillingEvent(), $billingEvent);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $billingEvent = BillingEventMock::create();

        $response = [
            'billingEvent' => $billingEvent->toArray(),
        ];

        $billingGetEventResponse = BillingGetEventResponse::fromResponse($response);

        $this->compareBillingEvent($billingGetEventResponse->getBillingEvent(), $billingEvent);
    }

}