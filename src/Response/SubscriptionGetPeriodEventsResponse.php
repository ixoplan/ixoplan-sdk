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

    /**
     * SubscriptionGetPeriodEventsResponse constructor.
     *
     * @param $periodEvents
     */
    public function __construct($periodEvents) {
        $this->periodEvents = $periodEvents;
    }

    /**
     * @return PeriodEvent[]
     */
    public function getPeriodEvents() {
        return $this->periodEvents;
    }

    /**
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse(array $response) {
        $periodEvents = [];
        foreach ($response['periodEvents'] as $subscriptionPeriodEvent) {
            $periodEvents[] = PeriodEvent::fromResponse($subscriptionPeriodEvent);
        }

        return new self($periodEvents);
    }

}