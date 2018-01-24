<?php

namespace Ixolit\Dislo\WorkingObjects;


/**
 * Class NextPackage
 *
 * @package Ixolit\Dislo\WorkingObjects
 *
 * @deprecated use Ixolit\Dislo\WorkingObjects\NextPackageObject instead
 */
class NextPackage extends Package implements WorkingObject {

    /** @var bool */
	private $paid;

	/** @var \DateTime */
	private $effectiveAt;

    /**
     * NextPackage constructor.
     *
     * @param string             $packageIdentifier
     * @param string             $serviceIdentifier
     * @param DisplayName[]      $displayNames
     * @param bool               $signupAvailable
     * @param Package[]          $addonPackages
     * @param \string[]          $metaData
     * @param PackagePeriod      $initialPeriod
     * @param PackagePeriod|null $recurringPeriod
     * @param bool               $paid
     * @param \DateTime          $effectiveAt
     */
    public function __construct($packageIdentifier,
                                $serviceIdentifier,
                                $displayNames,
                                $signupAvailable,
                                $addonPackages,
                                $metaData,
                                PackagePeriod $initialPeriod,
                                $recurringPeriod,
                                $paid,
                                \DateTime $effectiveAt
    ) {
		parent::__construct(
		    $packageIdentifier,
            $serviceIdentifier,
            $displayNames,
            $signupAvailable,
			$addonPackages,
            $metaData,
            $initialPeriod,
            $recurringPeriod
        );

		$this->paid = $paid;
		$this->effectiveAt = $effectiveAt;
	}

    /**
     * @return bool
     */
	public function isPaid() {
        return $this->paid;
    }

    /**
     * @return \DateTime
     */
    public function getEffectiveAt() {
	    return $this->effectiveAt;
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
			!empty($response['initialPeriod'])
                ? PackagePeriod::fromResponse($response['initialPeriod'])
                : null,
			!empty($response['recurringPeriod'])
                ? PackagePeriod::fromResponse($response['recurringPeriod'])
                : null,
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