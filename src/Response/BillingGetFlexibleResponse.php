<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingGetFlexibleResponse {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/**
	 * @param Flexible $flexible
	 */
	public function __construct(Flexible $flexible) {
		$this->flexible = $flexible;
	}

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetFlexibleResponse
	 */
	public static function fromResponse(array $response) {
		return new BillingGetFlexibleResponse(Flexible::fromResponse($response['flexible']));
	}
}