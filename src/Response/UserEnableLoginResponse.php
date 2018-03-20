<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserEnableLoginResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserEnableLoginResponse {

	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param User $user
	 */
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser() {
		return $this->user;
	}

    /**
     * @param array $response
     *
     * @return UserEnableLoginResponse
     */
	public static function fromResponse($response) {
		return new UserEnableLoginResponse(User::fromResponse($response['user']));
	}
}