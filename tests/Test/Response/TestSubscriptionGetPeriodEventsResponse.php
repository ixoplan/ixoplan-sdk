<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PeriodEventMock;
use Ixolit\Dislo\WorkingObjects\Subscription\PeriodEventObject;

/**
 * Class TestSubscriptionGetPeriodEventsResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionGetPeriodEventsResponse implements TestResponseInterface {

    /**
     * @var PeriodEventObject[]
     */
    private $periodEvents;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * TestSubscriptionGetPeriodEventsResponse constructor.
     */
    public function __construct() {
        $this->totalCount = MockHelper::getFaker()->randomNumber();

        $periodEventsCount = MockHelper::getFaker()->numberBetween(1, 5);

        for ($i = 0; $i < $periodEventsCount; $i++) {
            $periodEvent = PeriodEventMock::create();

            $this->periodEvents[$periodEvent->getPeriodEventId()] = $periodEvent;
        }
    }

    /**
     * @return PeriodEventObject[]
     */
    public function getPeriodEvents() {
        return $this->periodEvents;
    }

    /**
     * @return int
     */
    public function getTotalCount() {
        return $this->totalCount;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        $periodEvents = [];
        foreach ($this->getPeriodEvents() as $periodEvent) {
            $periodEvents[] = $periodEvent->toArray();
        }

        return [
            'subscriptionPeriodHistory' => $periodEvents,
            'totalCount'                => $this->getTotalCount(),
        ];
    }

}