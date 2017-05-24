<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\BillingEvent;

class BillingGetEventsForUserResponse {
	/**
	 * @var BillingEvent[]
	 */
	private $billingEvents;

	/** @var int total count of billing events for this user */
	private $totalCount;

	/**
	 * @param BillingEvent[] $billingEvents
	 * @param int|null $totalCount
	 */
	public function __construct($billingEvents, $totalCount = null) {
		$this->billingEvents = $billingEvents;
		$this->totalCount = $totalCount;
	}

	/**
	 * @return BillingEvent[]
	 */
	public function getBillingEvents() {
		return $this->billingEvents;
	}

	/**
	 * @return int
	 */
	public function getTotalCount() {
		return $this->totalCount;
	}

	/**
	 * @param array $response
	 *
	 * @return BillingGetEventsForUserResponse
	 */
	public static function fromResponse($response) {
		$billingEvents = [];
		foreach ($response['billingEvents'] as $billingEventArray) {
			$billingEvents[] = BillingEvent::fromResponse($billingEventArray);
		}

		return new BillingGetEventsForUserResponse(
			$billingEvents, isset($response['totalCount']) ? $response['totalCount'] : null
		);
	}
}