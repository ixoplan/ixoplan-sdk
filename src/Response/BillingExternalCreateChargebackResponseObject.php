<?php

namespace Ixolit\Dislo\Response;


/**
 * Class BillingExternalCreateChargebackResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalCreateChargebackResponseObject {

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
     * @return BillingExternalCreateChargebackResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['billingEventId']);
    }

}