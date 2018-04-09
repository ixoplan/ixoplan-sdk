<?php

use Ixolit\Dislo\Response\BillingGetFlexibleByIdentifierResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;

/**
 * Class BillingGetFlexibleByIdentifierResponseTest
 */
class BillingGetFlexibleByIdentifierResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $flexible = FlexibleMock::create();

        $billingGetFlexibleByIdentifierResponse = new BillingGetFlexibleByIdentifierResponse($flexible);

        $reflectionObject = new \ReflectionObject($billingGetFlexibleByIdentifierResponse);

        $flexibleProperty = $reflectionObject->getProperty('flexible');
        $flexibleProperty->setAccessible(true);
        $this->compareFlexible($flexibleProperty->getValue($billingGetFlexibleByIdentifierResponse), $flexible);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $flexible = FlexibleMock::create();

        $billingGetFlexibleByIdentifierResponse = new BillingGetFlexibleByIdentifierResponse($flexible);

        $this->compareFlexible($billingGetFlexibleByIdentifierResponse->getFlexible(), $flexible);
    }

    public function testFromResponse() {
        $flexible = FlexibleMock::create();

        $response = [
            'flexible' => $flexible->toArray(),
        ];

        $billingGetFlexibleByIdentifierResponse = BillingGetFlexibleByIdentifierResponse::fromResponse($response);

        $this->compareFlexible($billingGetFlexibleByIdentifierResponse->getFlexible(), $flexible);
    }

}