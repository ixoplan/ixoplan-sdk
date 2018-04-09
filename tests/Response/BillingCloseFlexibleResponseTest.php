<?php
use Ixolit\Dislo\Response\BillingCloseFlexibleResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\FlexibleMock;

/**
 * Class BillingCloseFlexibleResponseTest
 */
class BillingCloseFlexibleResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $flexible = FlexibleMock::create();

        $billingCloseFlexibleResponse = new BillingCloseFlexibleResponse($flexible);

        $reflectionObject = new \ReflectionObject($billingCloseFlexibleResponse);

        $flexibleProperty = $reflectionObject->getProperty('flexible');
        $flexibleProperty->setAccessible(true);
        $this->compareFlexible($flexibleProperty->getValue($billingCloseFlexibleResponse), $flexible);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $flexible = FlexibleMock::create();

        $billingCloseFlexibleResponse = new BillingCloseFlexibleResponse($flexible);

        $this->compareFlexible($billingCloseFlexibleResponse->getFlexible(), $flexible);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $flexible = FlexibleMock::create();

        $response = [
            'flexible' => $flexible->toArray(),
        ];

        $billingCloseFlexibleResponse = BillingCloseFlexibleResponse::fromResponse($response);

        $this->compareFlexible($billingCloseFlexibleResponse->getFlexible(), $flexible);
    }

}