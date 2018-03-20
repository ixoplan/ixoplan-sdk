<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\AuthToken;

/**
 * Class UserGetTokensResponse
 *
 * @package Ixolit\Dislo\Response
 */
class UserGetTokensResponse {

	/**
	 * @var AuthToken[]
	 */
	private $tokens;

	/**
	 * @param \Ixolit\Dislo\WorkingObjects\AuthToken[] $tokens
	 */
	public function __construct(array $tokens) {
		$this->tokens = $tokens;
	}

	/**
	 * @return \Ixolit\Dislo\WorkingObjects\AuthToken[]
	 */
	public function getTokens() {
		return $this->tokens;
	}

    /**
     * @param array $response
     *
     * @return UserGetTokensResponse
     */
	public static function fromResponse($response) {
		$tokens = [];
		foreach ($response['authTokens'] as $authTokenDefinition) {
			$tokens[] = AuthToken::fromResponse($authTokenDefinition);
		}
		return new UserGetTokensResponse($tokens);
	}
}