<?php

use Ixolit\Dislo\Response\BillingGetActiveRecurringResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\RecurringMock;

/**
 * Class BillingGetActiveRecurringResponseTest
 */
class BillingGetActiveRecurringResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $recurring = RecurringMock::create();

        $billingGetActiveRecurringResponse = new BillingGetActiveRecurringResponse($recurring);

        $reflectionObject = new \ReflectionObject($billingGetActiveRecurringResponse);

        $recurringProperty = $reflectionObject->getProperty('recurring');
        $recurringProperty->setAccessible(true);
        $this->compareRecurring($recurringProperty->getValue($billingGetActiveRecurringResponse), $recurring);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $recurring = RecurringMock::create();

        $billingGetActiveRecurringResponse = new BillingGetActiveRecurringResponse($recurring);

        $this->compareRecurring($billingGetActiveRecurringResponse->getRecurring(), $recurring);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $recurring = RecurringMock::create();

        $response = [
            'recurring' => $recurring->toArray(),
        ];

        $billingGetActiveRecurringResponse = BillingGetActiveRecurringResponse::fromResponse($response);

        $this->compareRecurring($billingGetActiveRecurringResponse->getRecurring(), $recurring);
    }

}