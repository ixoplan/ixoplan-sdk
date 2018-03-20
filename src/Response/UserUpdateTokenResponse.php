<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\AuthToken;

/**
 * Class UserUpdateTokenResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserUpdateTokenResponse {

	/**
	 * @var AuthToken
	 */
	private $authToken;

	/**
	 * @param AuthToken $authToken
	 */
	public function __construct(AuthToken $authToken) {
		$this->authToken = $authToken;
	}

	/**
	 * @return AuthToken
	 */
	public function getAuthToken() {
		return $this->authToken;
	}

    /**
     * @param array $response
     *
     * @return UserUpdateTokenResponse
     */
	public static function fromResponse($response) {
		return new UserUpdateTokenResponse(
			AuthToken::fromResponse($response['authToken'])
		);
	}
}