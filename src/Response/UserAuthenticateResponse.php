<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserAuthenticateResponse
 *
 * @package Ixolit\Dislo\Response
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

    /**
     * @param array $response
     *
     * @return UserAuthenticateResponse
     */
	public static function fromResponse($response) {
		return new UserAuthenticateResponse(
			User::fromResponse($response['user']),
			$response['authToken']
		);
	}
}