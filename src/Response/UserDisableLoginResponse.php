<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\User;

/**
 * Class UserDisableLoginResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserDisableLoginResponse {

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
     * @return UserDisableLoginResponse
     */
	public static function fromResponse($response) {
		return new UserDisableLoginResponse(User::fromResponse($response['user']));
	}
}