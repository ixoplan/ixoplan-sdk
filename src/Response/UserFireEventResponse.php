<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserFireEventResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserFireEventResponse {

    /**
     * @param array $response
     *
     * @return UserFireEventResponse
     */
	public static function fromResponse($response) {
		return new UserFireEventResponse();
	}
}