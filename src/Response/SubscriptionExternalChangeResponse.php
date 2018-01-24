<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionExternalChangeResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\SubscriptionExternalChangeResponseObject instead
 */
class SubscriptionExternalChangeResponse {
	/**
	 * @var int
	 */
	private $upgradeId;

	/**
	 * @param int $upgradeId
	 */
	public function __construct($upgradeId) {
		$this->upgradeId = $upgradeId;
	}

	/**
	 * @return int
	 */
	public function getUpgradeId() {
		return $this->upgradeId;
	}

	public static function fromResponse($response) {
		return new SubscriptionExternalChangeResponse($response['upgradeId']);
	}
}