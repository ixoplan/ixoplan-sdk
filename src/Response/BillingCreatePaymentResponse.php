<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;

/**
 * Class BillingCreatePaymentResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\BillingCreatePaymentResponseObject instead
 */
class BillingCreatePaymentResponse {
	private $redirectUrl;
	private $metaData = [];
	private $billingEvent;

	/**
	 * BillingCreatePaymentResponse constructor.
	 *
	 * @param string $redirectUrl
	 * @param array $metaData
	 * @param BillingEvent $billingEvent
	 */
	public function __construct($redirectUrl, $metaData, BillingEvent $billingEvent) {
		$this->redirectUrl  = $redirectUrl;
		$this->metaData     = $metaData;
		$this->billingEvent = $billingEvent;
	}

	/**
	 * @return string
	 */
	public function getRedirectUrl() {
		return $this->redirectUrl;
	}

	/**
	 * @return array
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @return BillingEvent
	 */
	public function getBillingEvent() {
		return $this->billingEvent;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingCreatePaymentResponse
	 */
	public static function fromResponse($response) {
		return new BillingCreatePaymentResponse(
			$response['redirectUrl'],
			$response['metaData'],
			BillingEvent::fromResponse($response['billingEvent'])
		);
	}
}