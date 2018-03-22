<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\NextPackageCustom;

/**
 * Class NextPackage
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class NextPackage extends Package {

    /**
     * @var bool
     */
	private $paid;

    /**
     * @var \DateTime
     */
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
    public function __construct(
        $packageIdentifier,
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
     * @return NextPackageCustom|null
     */
    public function getCustom() {
        /** @var NextPackageCustom $custom */
        $custom = ($this->getCustomObject() instanceof NextPackageCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
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
        return new self(
            static::getValueIsSet($response, 'packageIdentifier'),
            static::getValueIsSet($response, 'serviceIdentifier'),
            static::getValueIsSet($response, 'displayNames', [], function ($value) {
                $displayNames = [];
                foreach ($value as $displayName) {
                    $displayNames[] = DisplayName::fromResponse($displayName);
                }
                return $displayNames;
            }),
            static::getValueIsSet($response, 'signupAvailable'),
            static::getValueIsSet($response, 'addonPackages', [], function ($value) {
                $addonPackages = [];
                foreach ($value as $addonPackage) {
                    $addonPackages[] = Package::fromResponse($addonPackage);
                }
                return $addonPackages;
            }),
            static::getValueIsSet($response, 'metaData', array()),
            static::getValueIsSet($response, 'initialPeriod', null, function ($value) {
                return PackagePeriod::fromResponse($value);
            }),
            static::getValueIsSet($response, 'recurringPeriod', null, function ($value) {
                return PackagePeriod::fromResponse($value);
            }),
            static::getValueIsSet($response, 'paid'),
            static::getValueAsDateTime($response, 'effectiveAt')
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