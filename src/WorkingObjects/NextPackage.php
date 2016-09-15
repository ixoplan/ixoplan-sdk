<?php

namespace Ixolit\Dislo\WorkingObjects;

class NextPackage extends Package implements WorkingObject {
	private $paid;
	private $effectiveAt;

	public function __construct(
		$packageIdentifier, $serviceIdentifier, $displayNames, $signupAvailable,
		$addonPackages, $metaData, PackagePeriod $initialPeriod, $recurringPeriod,
		$paid, \DateTime $effectiveAt
	) {
		parent::__construct($packageIdentifier, $serviceIdentifier, $displayNames, $signupAvailable,
			$addonPackages, $metaData, $initialPeriod, $recurringPeriod);

		$this->paid = $paid;
		$this->effectiveAt = $effectiveAt;
	}

	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse($response) {
		$displayNames = [];
		foreach ($response['displayNames'] as $displayName) {
			$displayNames[] = DisplayName::fromResponse($displayName);
		}
		$addonPackages = [];
		foreach ($response['addonPackages'] as $addonPackage) {
			$addonPackages[] = Package::fromResponse($addonPackage);
		}
		return new NextPackage(
			$response['packageIdentifier'],
			$response['serviceIdentifier'],
			$displayNames,
			$response['signupAvailable'],
			$addonPackages,
			$response['metaData'],
			PackagePeriod::fromResponse($response['initialPeriod']),
			($response['recurringPeriod']?PackagePeriod::fromResponse($response['recurringPeriod']):null),
			$response['paid'],
			new \DateTime($response['effectiveAt'])
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$data = parent::toArray();
		$data['_type'] = 'NextPackage';
		$data['paid'] = $this->paid;
		$data['effectiveAt'] = $this->effectiveAt->format('Y-m-d H:i:s');
		return $data;
	}
}