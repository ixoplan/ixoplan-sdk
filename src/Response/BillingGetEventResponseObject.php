<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\BillingEventObject;

/**
 * Class BillingGetEventResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingGetEventResponseObject {

    /**
     * @var BillingEventObject
     */
    private $billingEvent;

    /**
     * @param BillingEventObject $billingEvent
     */
    public function __construct(BillingEventObject $billingEvent) {
        $this->billingEvent = $billingEvent;
    }

    /**
     * @return BillingEventObject
     */
    public function getBillingEvent() {
        return $this->billingEvent;
    }

    /**
     * @param array $response
     *
     * @return BillingGetEventResponseObject
     */
    public static function fromResponse($response) {
        return new self(BillingEventObject::fromResponse($response['billingEvent']));
    }

}