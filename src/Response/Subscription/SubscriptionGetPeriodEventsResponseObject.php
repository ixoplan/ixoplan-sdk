<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\Subscription\PeriodEventObject;


/**
 * Class SubscriptionGetPeriodEventsResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionGetPeriodEventsResponseObject {

    /**
     * @var PeriodEventObject[]
     */
    private $periodEvents;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * SubscriptionGetPeriodEventsResponse constructor.
     *
     * @param PeriodEventObject[] $periodEvents
     * @param int                 $totalCount
     */
    public function __construct($periodEvents, $totalCount) {
        $this->periodEvents = $periodEvents;
    }

    /**
     * @return PeriodEventObject[]
     */
    public function getPeriodEvents() {
        return $this->periodEvents;
    }

    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionGetPeriodEventsResponseObject
     */
    public static function fromResponse(array $response) {
        $periodEvents = [];
        foreach ($response['subscriptionPeriodHistory'] as $subscriptionPeriodEvent) {
            $periodEvents[] = PeriodEventObject::fromResponse($subscriptionPeriodEvent);
        }

        return new self($periodEvents, $response['totalCount']);
    }

}