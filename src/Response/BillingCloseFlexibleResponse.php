<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingCloseFlexible {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/**
	 * @param Flexible $flexible
	 */
	public function __construct($flexible) {
		$this->flexible = $flexible;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCloseFlexible
	 */
	public static function fromResponse(array $response) {
		return new BillingCloseFlexible(Flexible::fromResponse($response['flexible']));
	}

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}
}