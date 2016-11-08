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
	 * @param int $billingMethodId
	 * @param string $name
	 * @param string $displayName
	 */
	public function __construct($billingMethodId, $name, $displayName) {
		$this->billingMethodId = $billingMethodId;
		$this->name            = $name;
		$this->displayName     = $displayName;
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
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		return new BillingMethod(
			$response['billingMethodId'],
			$response['name'],
			$response['displayName']
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
			'displayName' => $this->getDisplayName()
		];
	}
}