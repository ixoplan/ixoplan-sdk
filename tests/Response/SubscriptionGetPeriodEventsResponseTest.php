<?php

use Ixolit\Dislo\Response\SubscriptionGetPeriodEventsResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PeriodEventMock;
use Ixolit\Dislo\WorkingObjects\PeriodEvent;
use function MongoDB\BSON\fromJSON;

/**
 * Class SubscriptionGetPeriodEventsResponseTest
 */
class SubscriptionGetPeriodEventsResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $periodEvent = PeriodEventMock::create();
        $periodEvents = [
            $periodEvent->getPeriodEventId() => $periodEvent,
        ];

        $totalCount = MockHelper::getFaker()->numberBetween();

        $subscriptionGetPeriodEventsResponse = new SubscriptionGetPeriodEventsResponse(
            $periodEvents,
            $totalCount
        );

        $reflectionObject = new \ReflectionObject($subscriptionGetPeriodEventsResponse);

        $periodEventsProperty = $reflectionObject->getProperty('periodEvents');
        $periodEventsProperty->setAccessible(true);

        /** @var PeriodEvent[] $testPeriodEvents */
        $testPeriodEvents = $periodEventsProperty->getValue($subscriptionGetPeriodEventsResponse);
        foreach ($testPeriodEvents as $testPeriodEvent) {
            if (empty($periodEvents[$testPeriodEvent->getPeriodEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePeriodEvent($testPeriodEvent, $periodEvents[$testPeriodEvent->getPeriodEventId()]);
        }

        $totalCountProperty = $reflectionObject->getProperty('totalCount');
        $totalCountProperty->setAccessible(true);
        $this->assertEquals($totalCount, $totalCountProperty->getValue($subscriptionGetPeriodEventsResponse));

    }

    /**
     * @return void
     */
    public function testGetters() {
        $periodEvent = PeriodEventMock::create();
        $periodEvents = [
            $periodEvent->getPeriodEventId() => $periodEvent,
        ];

        $totalCount = MockHelper::getFaker()->numberBetween();

        $subscriptionGetPeriodEventsResponse = new SubscriptionGetPeriodEventsResponse(
            $periodEvents,
            $totalCount
        );

        $testPeriodEvents = $subscriptionGetPeriodEventsResponse->getPeriodEvents();
        foreach ($testPeriodEvents as $testPeriodEvent) {
            if (empty($periodEvents[$testPeriodEvent->getPeriodEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePeriodEvent($testPeriodEvent, $periodEvents[$testPeriodEvent->getPeriodEventId()]);
        }

        $this->assertEquals($totalCount, $subscriptionGetPeriodEventsResponse->getTotalCount());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $periodEvent = PeriodEventMock::create();
        $periodEvents = [
            $periodEvent->getPeriodEventId() => $periodEvent,
        ];

        $response = [
            'subscriptionPeriodHistory' => \array_map(
                function($periodEvent) {
                    /** @var PeriodEvent $periodEvent */
                    return $periodEvent->toArray();
                },
                $periodEvents
            ),
            'totalCount' => MockHelper::getFaker()->numberBetween(),
        ];

        $subscriptionGetPeriodEventsResponse = SubscriptionGetPeriodEventsResponse::fromResponse($response);

        $testPeriodEvents = $subscriptionGetPeriodEventsResponse->getPeriodEvents();
        foreach ($testPeriodEvents as $testPeriodEvent) {
            if (empty($periodEvents[$testPeriodEvent->getPeriodEventId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePeriodEvent($testPeriodEvent, $periodEvents[$testPeriodEvent->getPeriodEventId()]);
        }

        $this->assertEquals($response['totalCount'], $subscriptionGetPeriodEventsResponse->getTotalCount());
    }

}