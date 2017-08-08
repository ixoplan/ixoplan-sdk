<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\PeriodEvent;


/**
 * Class SubscriptionGetPeriodEventsResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionGetPeriodEventsResponse {

    /** @var PeriodEvent[] */
    private $periodEvents;

    /** @var int */
    private $totalCount;

    /**
     * SubscriptionGetPeriodEventsResponse constructor.
     *
     * @param PeriodEvent[] $periodEvents
     * @param int           $totalCount
     */
    public function __construct($periodEvents, $totalCount) {
        $this->periodEvents = $periodEvents;
    }

    /**
     * @return PeriodEvent[]
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
     * @return self
     */
    public static function fromResponse(array $response) {
        $periodEvents = [];
        foreach ($response['subscriptionPeriodHistory'] as $subscriptionPeriodEvent) {
            $periodEvents[] = PeriodEvent::fromResponse($subscriptionPeriodEvent);
        }

        return new self($periodEvents, $response['totalCount']);
    }

}