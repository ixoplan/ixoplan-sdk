<?php

use Ixolit\Dislo\Response\BillingCreatePaymentResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class BillingCreatePaymentResponse
 */
class BillingCreatePaymentResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $redirectUrl = MockHelper::getFaker()->url;
        $metaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $billingEvent = BillingEventMock::create();

        $billingCreatePaymentResponse = new BillingCreatePaymentResponse($redirectUrl, $metaData, $billingEvent);

        $reflectionObject = new \ReflectionObject($billingCreatePaymentResponse);

        $redirectUrlProperty = $reflectionObject->getProperty('redirectUrl');
        $redirectUrlProperty->setAccessible(true);
        $this->assertEquals($redirectUrl, $redirectUrlProperty->getValue($billingCreatePaymentResponse));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($billingCreatePaymentResponse));

        $billingEventProperty = $reflectionObject->getProperty('billingEvent');
        $billingEventProperty->setAccessible(true);
        $this->compareBillingEvent($billingEventProperty->getValue($billingCreatePaymentResponse), $billingEvent);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $redirectUrl = MockHelper::getFaker()->url;
        $metaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $billingEvent = BillingEventMock::create();

        $billingCreatePaymentResponse = new BillingCreatePaymentResponse($redirectUrl, $metaData, $billingEvent);

        $this->assertEquals($redirectUrl, $billingCreatePaymentResponse->getRedirectUrl());
        $this->assertEquals($metaData, $billingCreatePaymentResponse->getMetaData());
        $this->compareBillingEvent($billingEvent, $billingCreatePaymentResponse->getBillingEvent());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $billingEvent = BillingEventMock::create();

        $response = [
            'redirectUrl'  => MockHelper::getFaker()->url,
            'metaData'     => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'billingEvent' => $billingEvent->toArray(),
        ];

        $billingCreatePaymentResponse = BillingCreatePaymentResponse::fromResponse($response);

        $this->assertEquals($response['redirectUrl'], $billingCreatePaymentResponse->getRedirectUrl());
        $this->assertEquals($response['metaData'], $billingCreatePaymentResponse->getMetaData());
        $this->compareBillingEvent($billingCreatePaymentResponse->getBillingEvent(), $billingEvent);
    }

}