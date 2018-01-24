<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingMethod;

/**
 * Class BillingMethodsGetResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\BillingMethodsGetResponseObject instead
 */
class BillingMethodsGetResponse {
	private $billingMethods;

	/**
	 * @param BillingMethod[] $billingMethods
	 */
	public function __construct($billingMethods) {
		$this->billingMethods = $billingMethods;
	}

	/**
	 * @return BillingMethod[]
	 */
	public function getBillingMethods() {
		return $this->billingMethods;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingMethodsGetResponse
	 */
	public static function fromResponse($response) {
		$billingMethods = [];
		foreach ($response['billingMethods'] as $billingMethodDefinition) {
			$billingMethods[] = BillingMethod::fromResponse($billingMethodDefinition);
		}

		return new BillingMethodsGetResponse($billingMethods);
	}
}