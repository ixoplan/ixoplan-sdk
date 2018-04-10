<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserRecoveryStartResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserRecoveryStartResponse {

    /**
     * @param array $response
     *
     * @return UserRecoveryStartResponse
     */
	public static function fromResponse($response) {
		return new UserRecoveryStartResponse();
	}
}