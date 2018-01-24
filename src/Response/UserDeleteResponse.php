<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserDeleteResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserDeleteResponseObject instead
 */
class UserDeleteResponse {

	public static function fromResponse($response) {
		return new UserDeleteResponse();
	}

}