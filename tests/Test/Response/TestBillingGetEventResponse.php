<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\BillingEventMock;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;

/**
 * Class TestBillingGetEventResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingGetEventResponse implements TestResponseInterface {

    /**
     * @var BillingEventObject
     */
    private $billingEvent;

    /**
     * TestBillingGetEventResponse constructor.
     */
    public function __construct() {
        $this->billingEvent = BillingEventMock::create();
    }

    /**
     * @return BillingEventObject
     */
    public function getBillingEvent() {
        return $this->billingEvent;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'billingEvent' => $this->getBillingEvent()->toArray(),
        ];
    }

}