<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserAuthenticateResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\UserAuthenticateResponseObject instead
 */
class UserAuthenticateResponse {
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $authToken;

	/**
	 * @param User   $user
	 * @param string $authToken
	 */
	public function __construct(User $user, $authToken) {
		$this->user      = $user;
		$this->authToken = $authToken;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

	/**
	 * @return string
	 */
	public function getAuthToken() {
		return $this->authToken;
	}

	public static function fromResponse($response) {
		return new UserAuthenticateResponse(
			User::fromResponse($response['user']),
			$response['authToken']
		);
	}
}