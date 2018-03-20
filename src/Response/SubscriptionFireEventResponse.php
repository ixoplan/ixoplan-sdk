<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionFireEventResponse
 *
 * @package Ixolit\Dislo\Response
 */
class SubscriptionFireEventResponse {

    /**
     * @param array $response
     *
     * @return SubscriptionFireEventResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionFireEventResponse();
	}
}