<?php

namespace Ixolit\Dislo\Response;


/**
 * Class BillingExternalCreateChargeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalCreateChargeResponseObject {

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
     * @return BillingExternalCreateChargeResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['billingEventId']);
    }

}