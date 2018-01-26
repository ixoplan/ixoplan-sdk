<?php

namespace Ixolit\Dislo\Response\Subscription;


/**
 * Class SubscriptionCallSpiResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionCallSpiResponseObject {

    /**
     * @var array
     */
    private $spiResponse;

    /**
     * @param array $spiResponse
     */
    public function __construct(array $spiResponse) {
        $this->spiResponse = $spiResponse;
    }

    /**
     * @return array
     */
    public function getSpiResponse() {
        return $this->spiResponse;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionCallSpiResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['spiResponse']);
    }

}