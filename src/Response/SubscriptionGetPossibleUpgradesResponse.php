<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class SubscriptionGetPossibleUpgradesResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\SubscriptionGetPossiblePackageChangesResponseObject instead
 */
class SubscriptionGetPossibleUpgradesResponse {
	/**
	 * @var Package[]
	 */
	private $packages = [];

	/**
	 * @param \Ixolit\Dislo\WorkingObjects\Package[] $packages
	 */
	public function __construct(array $packages) {
		$this->packages = $packages;
	}

	/**
	 * @return \Ixolit\Dislo\WorkingObjects\Package[]
	 */
	public function getPackages() {
		return $this->packages;
	}

	public static function fromResponse($data) {
		$result = [];
		foreach ($data['plans'] as $plan) {
			$result[] = Package::fromResponse($plan);
		}

		return new SubscriptionGetPossibleUpgradesResponse($result);
	}
}