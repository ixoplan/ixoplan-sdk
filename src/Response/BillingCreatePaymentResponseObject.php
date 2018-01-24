<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\BillingEventObject;

/**
 * Class BillingCreatePaymentResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
class BillingCreatePaymentResponseObject {

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var array
     */
    private $metaData = [];

    /**
     * @var BillingEventObject
     */
    private $billingEvent;

    /**
     * BillingCreatePaymentResponse constructor.
     *
     * @param string             $redirectUrl
     * @param array              $metaData
     * @param BillingEventObject $billingEvent
     */
    public function __construct($redirectUrl, $metaData, BillingEventObject $billingEvent) {
        $this->redirectUrl  = $redirectUrl;
        $this->metaData     = $metaData;
        $this->billingEvent = $billingEvent;
    }

    /**
     * @return string
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * @return array
     */
    public function getMetaData() {
        return $this->metaData;
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
     * @return BillingCreatePaymentResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            $response['redirectUrl'],
            $response['metaData'],
            BillingEventObject::fromResponse($response['billingEvent'])
        );
    }

}