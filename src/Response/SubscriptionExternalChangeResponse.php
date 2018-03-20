<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionExternalChangeResponse
 *
 * @package Ixolit\Dislo\Response
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

    /**
     * @param array $response
     *
     * @return SubscriptionExternalChangeResponse
     */
	public static function fromResponse($response) {
		return new SubscriptionExternalChangeResponse($response['upgradeId']);
	}
}