<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserRecoveryStartResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserRecoveryStartResponse {

    /**
     * UserRecoveryStartResponse constructor.
     */
	public function __construct() {
	}

    /**
     * @param array $response
     *
     * @return UserRecoveryStartResponse
     */
	public static function fromResponse($response) {
		return new UserRecoveryStartResponse();
	}
}