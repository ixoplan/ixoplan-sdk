<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserRecoveryStartResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserRecoveryStartResponseObject
 */
class UserRecoveryStartResponse {

	public function __construct() {
	}

	public static function fromResponse($response) {
		return new UserRecoveryStartResponse();
	}
}