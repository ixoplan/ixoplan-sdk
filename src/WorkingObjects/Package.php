<?php

namespace Ixolit\Dislo\WorkingObjects;

use Ixolit\Dislo\Exceptions\ObjectNotFoundException;

class Package implements WorkingObject {
	/**
	 * @var string
	 */
	private $packageIdentifier;
	/**
	 * @var string
	 */
	private $serviceIdentifier;
	/**
	 * @var DisplayName[]
	 */
	private $displayNames;
	/**
	 * @var bool
	 */
	private $signupAvailable;
	/**
	 * @var Package[]
	 */
	private $addonPackages;
	/**
	 * @var string[]
	 */
	private $metaData;
	/**
	 * @var PackagePeriod
	 */
	private $initialPeriod;
	/**
	 * @var PackagePeriod|null
	 */
	private $recurringPeriod;

	/** @var bool */
	private $hasTrialPeriod;

	/**
	 * @param string             $packageIdentifier
	 * @param string             $serviceIdentifier
	 * @param DisplayName[]      $displayNames
	 * @param bool               $signupAvailable
	 * @param Package[]          $addonPackages
	 * @param string[]           $metaData
	 * @param PackagePeriod|null $initialPeriod
	 * @param PackagePeriod|null $recurringPeriod
	 * @param bool               $hasTrialPeriod
	 */
	public function __construct($packageIdentifier, $serviceIdentifier, $displayNames, $signupAvailable,
								$addonPackages, $metaData, $initialPeriod, $recurringPeriod, $hasTrialPeriod = false) {
		$this->packageIdentifier = $packageIdentifier;
		$this->serviceIdentifier = $serviceIdentifier;
		$this->displayNames      = $displayNames;
		$this->signupAvailable   = $signupAvailable;
		$this->addonPackages     = $addonPackages;
		$this->metaData          = $metaData;
		$this->initialPeriod     = $initialPeriod;
		$this->recurringPeriod   = $recurringPeriod;
		$this->hasTrialPeriod    = $hasTrialPeriod;
	}

	/**
	 * @return string
	 */
	public function getPackageIdentifier() {
		return $this->packageIdentifier;
	}

	/**
	 * @return string
	 */
	public function getServiceIdentifier() {
		return $this->serviceIdentifier;
	}

	/**
	 * @return DisplayName[]
	 */
	public function getDisplayNames() {
		return $this->displayNames;
	}

	/**
	 * @param string $languageCode
	 * @return DisplayName
	 *
	 * @throws ObjectNotFoundException
	 */
	public function getDisplayNameForLanguage($languageCode) {
		foreach ($this->displayNames as $displayName) {
			if ($displayName->getLanguage() == $languageCode) {
				return $displayName;
			}
		}
		throw new ObjectNotFoundException('No display name for language ' . $languageCode . ' on package ' .
			$this->packageIdentifier);
	}

	/**
	 * @return boolean
	 */
	public function isSignupAvailable() {
		return $this->signupAvailable;
	}

	/**
	 * @return Package[]
	 */
	public function getAddonPackages() {
		return $this->addonPackages;
	}

	/**
	 * @return string[]
	 */
	public function getMetaData() {
		return $this->metaData;
	}

	/**
	 * @return PackagePeriod|null
	 */
	public function getInitialPeriod() {
		return $this->initialPeriod;
	}

	/**
	 * @return PackagePeriod|null
	 */
	public function getRecurringPeriod() {
		return $this->recurringPeriod;
	}

	/**
	 * @return bool
	 */
	public function hasTrialPeriod() {
		return $this->hasTrialPeriod;
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
		return new Package(
			$response['packageIdentifier'],
			$response['serviceIdentifier'],
			$displayNames,
			$response['signupAvailable'],
			$addonPackages,
			$response['metaData'],
			($response['initialPeriod']?PackagePeriod::fromResponse($response['initialPeriod']):null),
			($response['recurringPeriod']?PackagePeriod::fromResponse($response['recurringPeriod']):null),
			(isset($response['hasTrialPeriod']) ? $response['hasTrialPeriod'] : false)
		);
	}

	/**
	 * @return array
	 */
	public function toArray() {
		$displayNames = [];
		foreach ($this->displayNames as $displayName) {
			$displayNames[] = $displayName->toArray();
		}

		$addonPackages = [];
		foreach ($this->addonPackages as $package) {
			$addonPackages[] = $package->toArray();
		}

		return [
			'_type' => 'Package',
			'packageIdentifier' => $this->packageIdentifier,
			'serviceIdentifier' => $this->serviceIdentifier,
			'displayNames'      => $displayNames,
			'signupAvailable'   => $this->signupAvailable,
			'addonPackages'     => $addonPackages,
			'metaData'          => $this->metaData,
			'initialPeriod'     => $this->initialPeriod->toArray(),
			'recurringPeriod'   => ($this->recurringPeriod?$this->recurringPeriod->toArray():null)
		];
	}
}