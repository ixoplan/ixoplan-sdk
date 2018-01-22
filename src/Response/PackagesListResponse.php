<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class PackagesListResponse
 *
 * @package Ixolit\Dislo\Response
 *
 * @deprecated use Ixolit\Dislo\Response\PlanListResponse instead
 */
class PackagesListResponse {
	/**
	 * @var Package[]
	 */
	private $packages;

	/**
	 * @param Package[] $packages
	 */
	public function __construct(array $packages) {
		$this->packages = $packages;
	}

	/**
	 * @return Package[]
	 */
	public function getPackages() {
		return $this->packages;
	}

	public static function fromResponse($response) {
		$packages = [];
		foreach ($response['packages'] as $packageDefinition) {
			$packages[] = Package::fromResponse($packageDefinition);
		}
		return new PackagesListResponse($packages);
	}
}