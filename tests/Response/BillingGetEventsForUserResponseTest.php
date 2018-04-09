<?php

use Ixolit\Dislo\Response\BillingGetEventsForUserResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\BillingEvent;

/**
 * Class BillingGetEventsForUserResponseTest
 */
class BillingGetEventsForUserResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $billingEvent = BillingEventMock::create();
        $billingEvents = [
            $billingEvent->getBillingEventId() => $billingEvent,
        ];

        $totalCount = MockHelper::getFaker()->numberBetween();

        $billingGetEventsForUserResponse = new BillingGetEventsForUserResponse($billingEvents, $totalCount);

        $reflectionObject = new \ReflectionObject($billingGetEventsForUserResponse);

        $billingEventsProperty = $reflectionObject->getProperty('billingEvents');
        $billingEventsProperty->setAccessible(true);

        /** @var BillingEvent[] $testBillingEvents */
        $testBillingEvents = $billingEventsProperty->getValue($billingGetEventsForUserResponse);
        foreach ($testBillingEvents as $testBillingEvent) {
            if (empty($billingEvents[$testBillingEvent->getBillingEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingEvent($testBillingEvent, $billingEvents[$testBillingEvent->getBillingEventId()]);
        }

        $totalCountProperty = $reflectionObject->getProperty('totalCount');
        $totalCountProperty->setAccessible(true);
        $this->assertEquals($totalCount, $totalCountProperty->getValue($billingGetEventsForUserResponse));

        new BillingGetEventsForUserResponse($billingEvents);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $billingEvent = BillingEventMock::create();
        $billingEvents = [
            $billingEvent->getBillingEventId() => $billingEvent,
        ];

        $totalCount = MockHelper::getFaker()->numberBetween();

        $billingGetEventsForUserResponse = new BillingGetEventsForUserResponse($billingEvents, $totalCount);

        $testBillingEvents = $billingGetEventsForUserResponse->getBillingEvents();
        foreach ($testBillingEvents as $testBillingEvent) {
            if (empty($billingEvents[$testBillingEvent->getBillingEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingEvent($testBillingEvent, $billingEvents[$testBillingEvent->getBillingEventId()]);
        }

        $this->assertEquals($totalCount, $billingGetEventsForUserResponse->getTotalCount());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $billingEvent = BillingEventMock::create();
        $billingEvents = [
            $billingEvent->getBillingEventId() => $billingEvent,
        ];

        $response = [
            'billingEvents' => \array_map(
                function($billingEvent) {
                    /** @var BillingEvent $billingEvent */
                    return $billingEvent->toArray();
                },
                $billingEvents
            ),
            'totalCount' => MockHelper::getFaker()->numberBetween()
        ];

        $billingGetEventsForUserResponse = BillingGetEventsForUserResponse::fromResponse($response);

        $testBillingEvents = $billingGetEventsForUserResponse->getBillingEvents();
        foreach ($testBillingEvents as $testBillingEvent) {
            if (empty($billingEvents[$testBillingEvent->getBillingEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingEvent($testBillingEvent, $billingEvents[$testBillingEvent->getBillingEventId()]);
        }

        $this->assertEquals($response['totalCount'], $billingGetEventsForUserResponse->getTotalCount());
    }

}