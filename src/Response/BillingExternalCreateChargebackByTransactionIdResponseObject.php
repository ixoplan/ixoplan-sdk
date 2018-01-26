<?php

namespace Ixolit\Dislo\Response;


/**
 * Class BillingExternalCreateChargebackByTransactionIdResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingExternalCreateChargebackByTransactionIdResponseObject {

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
     * @return BillingExternalCreateChargebackByTransactionIdResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['billingEventId']);
    }

}