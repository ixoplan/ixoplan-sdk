<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class TestBillingExternalCreateChargeResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestBillingExternalCreateChargeResponse implements TestResponseInterface {

    /**
     * @var int
     */
    private $billingEventId;

    /**
     * TestBillingExternalCreateChargeResponse constructor.
     */
    public function __construct() {
        $this->billingEventId = MockHelper::getFaker()->randomNumber();
    }

    /**
     * @return int
     */
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