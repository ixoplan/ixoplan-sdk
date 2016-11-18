<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Package;

class PackageGetResponse {
	/**
	 * @var Package
	 */
	private $package;

	/**
	 * @param Package $package
	 */
	public function __construct(Package $package) {
		$this->package = $package;
	}

	/**
	 * @return Package
	 */
	public function getPackage() {
		return $this->package;
	}

	public static function fromResponse($response) {
		return new PackageGetResponse(Package::fromResponse($response));
	}
}