<?php

namespace Ixolit\Dislo\WorkingObjects;

class BillingMethod implements WorkingObject {
	/**
	 * @var int
	 */
	private $billingMethodId;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $displayName;

	/**
	 * @var bool|null
	 */
	private $available;

	/**
	 * @param int    	$billingMethodId
	 * @param string 	$name
	 * @param string 	$displayName
	 * @param bool|null $available
	 */
	public function __construct($billingMethodId, $name, $displayName, $available = null) {
		$this->billingMethodId = $billingMethodId;
		$this->name            = $name;
		$this->displayName     = $displayName;
		$this->available       = $available;
	}

	/**
	 * @return int
	 */
	public function getBillingMethodId() {
		return $this->billingMethodId;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDisplayName() {
		return $this->displayName;
	}

	/**
	 * @return bool|null
	 */
	public function isAvailable() {
		return $this->available;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new BillingMethod(
			$response['billingMethodId'],
			$response['name'],
			$response['displayName'],
			isset($response['available']) ? $response['available'] : null
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		return [
			'_type' => 'BillingMethod',
			'billingMethodId' => $this->getBillingMethodId(),
			'name' => $this->getName(),
			'displayName' => $this->getDisplayName(),
			'available' => $this->isAvailable(),
		];
	}
}