<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class TestBillingExternalCreateChargebackByTransactionIdResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingExternalCreateChargebackByTransactionIdResponse implements TestResponseInterface {

    /**
     * @var int
     */
    private $billingEventId;

    /**
     * TestBillingExternalCreateChargebackByTransactionIdResponse constructor.
     */
    public function __construct() {
        $this->billingEventId = MockHelper::getFaker()->randomNumber();
    }

    public function getBillingEventId() {
        return $this->billingEventId;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'billingEventId' => $this->getBillingEventId(),
        ];
    }

}