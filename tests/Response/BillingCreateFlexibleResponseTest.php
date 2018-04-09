<?php

use Ixolit\Dislo\Response\BillingCreateFlexibleResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class BillingcreateflexibleResponseTest
 */
class BillingCreateFlexibleResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $flexible = FlexibleMock::create();
        $redirectUrl = MockHelper::getFaker()->url;

        $billingCreateFlexibleResponse = new BillingCreateFlexibleResponse($flexible, $redirectUrl);

        $reflectionObject = new \ReflectionObject($billingCreateFlexibleResponse);

        $flexibleProperty = $reflectionObject->getProperty('flexible');
        $flexibleProperty->setAccessible(true);
        $this->compareFlexible($flexibleProperty->getValue($billingCreateFlexibleResponse), $flexible);

        $redirectUrlProperty = $reflectionObject->getProperty('redirectUrl');
        $redirectUrlProperty->setAccessible(true);
        $this->assertEquals($redirectUrl, $redirectUrlProperty->getValue($billingCreateFlexibleResponse));
    }

    /**
     * @return void
     */
    public function testGetters() {
        $flexible = FlexibleMock::create();
        $redirectUrl = MockHelper::getFaker()->url;

        $billingCreateFlexibleResponse = new BillingCreateFlexibleResponse($flexible, $redirectUrl);

        $this->compareFlexible($billingCreateFlexibleResponse->getFlexible(), $flexible);
        $this->assertEquals($redirectUrl, $billingCreateFlexibleResponse->getRedirectUrl());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $flexible = FlexibleMock::create();

        $response = [
            'flexible'    => $flexible->toArray(),
            'redirectUrl' => MockHelper::getFaker()->url,
        ];

        $billingCreateFlexibleResponse = BillingCreateFlexibleResponse::fromResponse($response);

        $this->compareFlexible($billingCreateFlexibleResponse->getFlexible(), $flexible);
        $this->assertEquals($response['redirectUrl'], $billingCreateFlexibleResponse->getRedirectUrl());
    }

}