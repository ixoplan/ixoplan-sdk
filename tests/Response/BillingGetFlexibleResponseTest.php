<?php

use Ixolit\Dislo\Response\BillingGetFlexibleResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;

/**
 * Class BillingGetFlexibleResponseTest
 */
class BillingGetFlexibleResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstruct() {
        $flexible = FlexibleMock::create();

        $billingGetFlexibleResponse = new BillingGetFlexibleResponse($flexible);

        $reflectionObject = new \ReflectionObject($billingGetFlexibleResponse);

        $flexibleProperty = $reflectionObject->getProperty('flexible');
        $flexibleProperty->setAccessible(true);
        $this->compareFlexible($flexibleProperty->getValue($billingGetFlexibleResponse), $flexible);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $flexible = FlexibleMock::create();

        $billingGetFlexibleResponse = new BillingGetFlexibleResponse($flexible);

        $this->compareFlexible($billingGetFlexibleResponse->getFlexible(), $flexible);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $flexible = FlexibleMock::create();

        $response = [
            'flexible' => $flexible->toArray()
        ];

        $billingGetFlexibleResponse = BillingGetFlexibleResponse::fromResponse($response);

        $this->compareFlexible($billingGetFlexibleResponse->getFlexible(), $flexible);
    }

}