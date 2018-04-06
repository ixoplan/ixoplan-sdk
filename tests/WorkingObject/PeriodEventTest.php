<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\BillingEvent;
use Ixolit\Dislo\WorkingObjects\PeriodEvent;
use Ixolit\Dislo\WorkingObjectsCustom\PeriodEventCustom;

/**
 * Class PeriodEventTest
 */
class PeriodEventTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $periodEventId         = MockHelper::getFaker()->uuid;
        $periodId              = MockHelper::getFaker()->uuid;
        $subscriptionHistoryId = MockHelper::getFaker()->uuid;
        $startedAt             = MockHelper::getFaker()->dateTime();
        $endsAt                = MockHelper::getFaker()->dateTime();
        $parentPeriodEventId   = MockHelper::getFaker()->uuid;
        $originalEndsAt        = MockHelper::getFaker()->dateTime();
        $billingEvent          = BillingEventMock::create();

        $periodEvent = new PeriodEvent(
            $periodEventId,
            $periodId,
            $subscriptionHistoryId,
            $startedAt,
            $endsAt,
            $parentPeriodEventId,
            $originalEndsAt,
            $billingEvent
        );

        $reflectionObject = new \ReflectionObject($periodEvent);

        $periodEventIdProperty = $reflectionObject->getProperty('periodEventId');
        $periodEventIdProperty->setAccessible(true);
        $this->assertEquals($periodEventId, $periodEventIdProperty->getValue($periodEvent));

        $periodIdProperty = $reflectionObject->getProperty('periodId');
        $periodIdProperty->setAccessible(true);
        $this->assertEquals($periodId, $periodIdProperty->getValue($periodEvent));

        $subscriptionHistoryIdProperty = $reflectionObject->getProperty('subscriptionHistoryId');
        $subscriptionHistoryIdProperty->setAccessible(true);
        $this->assertEquals($subscriptionHistoryId, $subscriptionHistoryIdProperty->getValue($periodEvent));

        $startedAtProperty = $reflectionObject->getProperty('startedAt');
        $startedAtProperty->setAccessible(true);
        $this->assertEquals($startedAt, $startedAtProperty->getValue($periodEvent));

        $endsAtProperty = $reflectionObject->getProperty('endsAt');
        $endsAtProperty->setAccessible(true);
        $this->assertEquals($endsAt, $endsAtProperty->getValue($periodEvent));

        $parentPeriodEventIdProperty = $reflectionObject->getProperty('parentPeriodEventId');
        $parentPeriodEventIdProperty->setAccessible(true);
        $this->assertEquals($parentPeriodEventId, $parentPeriodEventIdProperty->getValue($periodEvent));

        $originalEndsAtProperty = $reflectionObject->getProperty('originalEndsAt');
        $originalEndsAtProperty->setAccessible(true);
        $this->assertEquals($originalEndsAt, $originalEndsAtProperty->getValue($periodEvent));

        $billingEventProperty = $reflectionObject->getProperty('billingEvent');
        $billingEventProperty->setAccessible(true);
        $this->assertEquals($billingEvent, $billingEventProperty->getValue($periodEvent));

        new PeriodEvent(
            $periodEventId,
            $periodId,
            $subscriptionHistoryId
        );

        $this->assertTrue(true);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $periodEventId         = MockHelper::getFaker()->uuid;
        $periodId              = MockHelper::getFaker()->uuid;
        $subscriptionHistoryId = MockHelper::getFaker()->uuid;
        $startedAt             = MockHelper::getFaker()->dateTime();
        $endsAt                = MockHelper::getFaker()->dateTime();
        $parentPeriodEventId   = MockHelper::getFaker()->uuid;
        $originalEndsAt        = MockHelper::getFaker()->dateTime();
        $billingEvent          = BillingEventMock::create();

        $periodEvent = new PeriodEvent(
            $periodEventId,
            $periodId,
            $subscriptionHistoryId,
            $startedAt,
            $endsAt,
            $parentPeriodEventId,
            $originalEndsAt,
            $billingEvent
        );

        $this->assertEquals($periodEventId, $periodEvent->getPeriodEventId());
        $this->assertEquals($periodId, $periodEvent->getPeriodId());
        $this->assertEquals($subscriptionHistoryId, $periodEvent->getSubscriptionHistoryId());
        $this->assertEquals($startedAt, $periodEvent->getStartedAt());
        $this->assertEquals($endsAt, $periodEvent->getEndsAt());
        $this->assertEquals($parentPeriodEventId, $periodEvent->getParentPeriodEventId());
        $this->assertEquals($originalEndsAt, $periodEvent->getOriginalEndsAt());
        $this->compareBillingEvent($periodEvent->getBillingEvent(), $billingEvent);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $startedAt             = MockHelper::getFaker()->dateTime();
        $endsAt                = MockHelper::getFaker()->dateTime();
        $originalEndsAt        = MockHelper::getFaker()->dateTime();
        $billingEvent          = BillingEventMock::create();

        $response = [
            'id'                    => MockHelper::getFaker()->uuid,
            'periodId'              => MockHelper::getFaker()->uuid,
            'subscriptionHistoryId' => MockHelper::getFaker()->uuid,
            'startedAt'             => $startedAt->format('Y-m-d H:i:s'),
            'endsAt'                => $endsAt->format('Y-m-d H:i:s'),
            'parentPeriodEventId'   => MockHelper::getFaker()->uuid,
            'originalEndsAt'        => $originalEndsAt->format('Y-m-d H:i:s'),
            'billingEvent'          => $billingEvent->toArray(),
        ];

        $periodEvent = PeriodEvent::fromResponse($response);

        $this->assertEquals($response['id'], $periodEvent->getPeriodEventId());
        $this->assertEquals($response['periodId'], $periodEvent->getPeriodId());
        $this->assertEquals($response['subscriptionHistoryId'], $periodEvent->getSubscriptionHistoryId());
        $this->assertEquals($startedAt, $periodEvent->getStartedAt());
        $this->assertEquals($endsAt, $periodEvent->getEndsAt());
        $this->assertEquals($response['parentPeriodEventId'], $periodEvent->getParentPeriodEventId());
        $this->assertEquals($originalEndsAt, $periodEvent->getOriginalEndsAt());
        $this->compareBillingEvent($periodEvent->getBillingEvent(), $billingEvent);
    }

    /**
     * @return void
     */
    public function testToArray() {
        $startedAt             = MockHelper::getFaker()->dateTime();
        $endsAt                = MockHelper::getFaker()->dateTime();
        $originalEndsAt        = MockHelper::getFaker()->dateTime();
        $billingEvent          = BillingEventMock::create();

        $periodEvent = new PeriodEvent(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            $startedAt,
            $endsAt,
            MockHelper::getFaker()->uuid,
            $originalEndsAt,
            $billingEvent
        );

        $periodEventArray = $periodEvent->toArray();

        $this->assertEquals($periodEvent->getPeriodEventId(), $periodEventArray['id']);
        $this->assertEquals($periodEvent->getPeriodId(), $periodEventArray['periodId']);
        $this->assertEquals($periodEvent->getSubscriptionHistoryId(), $periodEventArray['subscriptionHistoryId']);
        $this->assertEquals($startedAt->format('Y-m-d H:i:s'), $periodEventArray['startedAt']);
        $this->assertEquals($endsAt->format('Y-m-d H:i:s'), $periodEventArray['endsAt']);
        $this->assertEquals($periodEvent->getParentPeriodEventId(), $periodEventArray['parentPeriodEventId']);
        $this->assertEquals($originalEndsAt->format('Y-m-d H:i:s'), $periodEventArray['originalEndsAt']);
        $this->compareBillingEvent(BillingEvent::fromResponse($periodEventArray['billingEvent']), $billingEvent);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $periodEvent = new PeriodEvent(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->dateTime(),
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->dateTime(),
            BillingEventMock::create()
        );

        $periodEventCustomObject = $periodEvent->getCustom();

        $this->assertInstanceOf(PeriodEventCustom::class, $periodEventCustomObject);
    }

}