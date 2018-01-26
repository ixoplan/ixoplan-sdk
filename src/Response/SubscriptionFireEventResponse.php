<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionFireEventResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\SubscriptionFireEventResponseObject instead
 */
class SubscriptionFireEventResponse {

	public static function fromResponse($response) {
		return new SubscriptionFireEventResponse();
	}
}