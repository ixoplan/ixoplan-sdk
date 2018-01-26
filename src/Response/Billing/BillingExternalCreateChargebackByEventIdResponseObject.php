<?php

namespace Ixolit\Dislo\Response\Billing;


/**
 * Class BillingExternalCreateChargebackByEventIdResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalCreateChargebackByEventIdResponseObject {

    /**
     * @var int
     */
    private $billingEventId;

    /**
     * @param int $billingEventId
     */
    public function __construct($billingEventId) {
        $this->billingEventId = $billingEventId;
    }

    /**
     * @return int
     */
    public function getBillingEventId() {
        return $this->billingEventId;
    }

    /**
     * @param array $response
     *
     * @return BillingExternalCreateChargebackByEventIdResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['billingEventId']);
    }

}