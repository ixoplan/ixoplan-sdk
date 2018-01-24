<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

/**
 * Class BillingCloseFlexibleResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\BillingCloseFlexibleResponseObject instead
 */
class BillingCloseFlexibleResponse {
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
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCloseFlexibleResponse
	 */
	public static function fromResponse($response) {
		return new BillingCloseFlexibleResponse(Flexible::fromResponse($response['flexible']));
	}
}