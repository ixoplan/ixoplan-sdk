<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;

/**
 * Class TestBillingGetEventsForUserResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingGetEventsForUserResponse implements TestResponseInterface {

    /**
     * @var BillingEventObject[]
     */
    private $billingEvents;

    /**
     * @var int
     */
    private $totalCount;

    /**
     * TestBillingGetEventsForUserResponse constructor.
     */
    public function __construct() {
        $this->totalCount = MockHelper::getFaker()->randomNumber();

        $billingEventsCount = MockHelper::getFaker()->numberBetween(1, 5);

        $this->billingEvents = [];
        for ($i = 0; $i < $billingEventsCount; $i++) {
            $billingEvent = BillingEventMock::create();

            $this->billingEvents[$billingEvent->getBillingEventId()] = $billingEvent;
        }
    }

    /**
     * @return BillingEventObject[]
     */
    public function getBillingEvents() {
        return $this->billingEvents;
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
        $response = [
            'totalCount' => $this->getTotalCount(),
        ];

        $billingEvents = [];
        foreach ($this->getBillingEvents() as $billingEvent) {
            $billingEvents[] = $billingEvent->toArray();
        }

        $response['billingEvents'] = $billingEvents;

        return $response;
    }

}