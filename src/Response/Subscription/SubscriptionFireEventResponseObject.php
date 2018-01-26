<?php

namespace Ixolit\Dislo\Response\Subscription;


/**
 * Class SubscriptionFireEventResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionFireEventResponseObject {

    /**
     * @param array $response
     *
     * @return SubscriptionFireEventResponseObject
     */
    public static function fromResponse($response) {
        return new self();
    }

}