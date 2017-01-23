<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Flexible;

class BillingCreateFlexibleResponse {
	/**
	 * @var Flexible
	 */
	private $flexible;

	/** @var string */
	private $redirectUrl;

	/**
	 * @param Flexible      $flexible
	 * @param string|null   $redirectUrl
	 */
	public function __construct($flexible, $redirectUrl = null) {
		$this->flexible = $flexible;
		$this->redirectUrl = $redirectUrl;
	}

	/**
	 * @return Flexible
	 */
	public function getFlexible() {
		return $this->flexible;
	}

	/**
	 * @return null|string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCreateFlexibleResponse
	 */
	public static function fromResponse($response) {
		return new BillingCreateFlexibleResponse(
			Flexible::fromResponse($response['flexible']),
			isset($response['redirectUrl']) ? $response['redirectUrl'] : null
		);
	}
}