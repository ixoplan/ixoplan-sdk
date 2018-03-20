<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserDeleteResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserDeleteResponse {

    /**
     * @param array $response
     *
     * @return UserDeleteResponse
     */
	public static function fromResponse($response) {
		return new UserDeleteResponse();
	}

}