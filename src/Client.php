<?php

namespace Ixolit\Dislo;

use Ixolit\Dislo\Request\CDERequestClient;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\WorkingObjects\Flexible;
use Ixolit\Dislo\WorkingObjects\User;

/**
 * The main client class for use with the Dislo API. Requires a RequestClient class as a parameter when not running
 * inside the CDE. (e.g. HTTPRequestClient
 */
class Client {
	/**
	 * @var RequestClient
	 */
	private $requestClient;

	/**
	 * @param RequestClient|null $requestClient Required when not running in the CDE.
	 *
	 * @throws \Exception
	 */
	public function __construct(RequestClient $requestClient = null) {
		if (!$requestClient) {
			if (\function_exists('\\apiCall')) {
				$requestClient = new CDERequestClient();
			} else {
				throw new \Exception('A RequestClient parameter is required when not running in the CDE!');
			}
		}
		$this->requestClient = $requestClient;
	}

	/**
	 * @param User|int     $user
	 * @param Flexible|int $flexible
	 *
	 * @return Flexible
	 */
	public function billingCloseFlexible($user, $flexible) {
		$response = $this->requestClient->request('/frontend/billing/closeFlexible', [
			'userId' => ($user instanceof User?$user->getId():(int)$user),
			'flexibleId' => ($flexible instanceof Flexible?$flexible->getId():(int)$flexible)
		]);
		return Flexible::fromResponse($response['flexible']);
	}
}
