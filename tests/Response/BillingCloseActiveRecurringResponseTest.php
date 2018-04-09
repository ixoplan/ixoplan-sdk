<?php
use Ixolit\Dislo\Response\BillingCloseActiveRecurringResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\RecurringMock;

/**
 * Class BillingCloseActiveRecurringResponseTest
 */
class BillingCloseActiveRecurringResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $recurring = RecurringMock::create();

        $billingCloseActiveRecurringResponse = new BillingCloseActiveRecurringResponse($recurring);

        $reflectionObject = new \ReflectionObject($billingCloseActiveRecurringResponse);

        $recurringProperty = $reflectionObject->getProperty('recurring');
        $recurringProperty->setAccessible(true);
        $this->compareRecurring($recurringProperty->getValue($billingCloseActiveRecurringResponse), $recurring);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $recurring = RecurringMock::create();

        $billingCloseActiveRecurringResponse = new BillingCloseActiveRecurringResponse($recurring);

        $this->compareRecurring($billingCloseActiveRecurringResponse->getRecurring(), $recurring);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $recurring = RecurringMock::create();

        $response = [
            'recurring' => $recurring->toArray(),
        ];

        $billingCloseActiveRecurringResponse = BillingCloseActiveRecurringResponse::fromResponse($response);

        $this->compareRecurring($billingCloseActiveRecurringResponse->getRecurring(), $recurring);
    }

}