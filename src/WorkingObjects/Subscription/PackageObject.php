<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\Exceptions\ObjectNotFoundException;
use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjects\Billing\BillingMethodObject;
use Ixolit\Dislo\WorkingObjectsCustom\Subscription\PackageCustom;

/**
 * Class PackageObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class PackageObject extends AbstractWorkingObject {

    /**
     * @var string
     */
    private $packageIdentifier;
    /**
     * @var string
     */
    private $serviceIdentifier;

    /**
     * @var DisplayNameObject[]
     */
    private $displayNames;
    /**
     * @var bool
     */
    private $signupAvailable;
    /**
     * @var PackageObject[]
     */
    private $addonPackages;
    /**
     * @var string[]
     */
    private $metaData;
    /**
     * @var PackagePeriodObject
     */
    private $initialPeriod;
    /**
     * @var PackagePeriodObject|null
     */
    private $recurringPeriod;

    /**
     * @var bool
     */
    private $hasTrialPeriod;

    /**
     * @var BillingMethodObject[]
     */
    private $billingMethods;

    /**
     * @var bool
     */
    private $requireFlexibleForFreeSignup;

    /**
     * @param string                   $packageIdentifier
     * @param string                   $serviceIdentifier
     * @param DisplayNameObject[]      $displayNames
     * @param bool                     $signupAvailable
     * @param PackageObject[]          $addonPackages
     * @param string[]                 $metaData
     * @param PackagePeriodObject|null $initialPeriod
     * @param PackagePeriodObject|null $recurringPeriod
     * @param bool                     $hasTrialPeriod
     * @param BillingMethodObject[]    $billingMethods
     * @param bool                     $requireFlexibleForFreeSignup
     */
    public function __construct(
        $packageIdentifier,
        $serviceIdentifier,
        $displayNames,
        $signupAvailable,
        $addonPackages,
        $metaData,
        $initialPeriod,
        $recurringPeriod,
        $hasTrialPeriod = false,
        $billingMethods = null,
        $requireFlexibleForFreeSignup = false
    ) {
        $this->packageIdentifier            = $packageIdentifier;
        $this->serviceIdentifier            = $serviceIdentifier;
        $this->displayNames                 = $displayNames;
        $this->signupAvailable              = $signupAvailable;
        $this->addonPackages                = $addonPackages;
        $this->metaData                     = $metaData;
        $this->initialPeriod                = $initialPeriod;
        $this->recurringPeriod              = $recurringPeriod;
        $this->hasTrialPeriod               = $hasTrialPeriod;
        $this->billingMethods               = $billingMethods;
        $this->requireFlexibleForFreeSignup = $requireFlexibleForFreeSignup;
        $this->addCustomObject();
    }

    /**
     * @return PackageCustom|null
     */
    public function getCustom() {
        /** @var PackageCustom $custom */
        $custom = ($this->getCustomObject() instanceof PackageCustom) ? $this->getCustomObject() : null;
        return $custom;
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
     * @return DisplayNameObject[]
     */
    public function getDisplayNames() {
        return $this->displayNames;
    }

    /**
     * @param string $languageCode
     *
     * @return DisplayNameObject
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
     * @return PackageObject[]
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
     * @param string $metaDataName
     *
     * @return null|string
     */
    public function getMetaDataEntry($metaDataName) {
        $metaData = $this->getMetaData();

        return isset($metaData[$metaDataName]) ? $metaData[$metaDataName] : null;
    }

    /**
     * @return PackagePeriodObject|null
     */
    public function getInitialPeriod() {
        return $this->initialPeriod;
    }

    /**
     * @return PackagePeriodObject|null
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
     * @return BillingMethodObject[]
     */
    public function getBillingMethods() {
        return $this->billingMethods;
    }

    /**
     * @return bool
     */
    public function requiresFlexibleForFreeSignup() {
        return $this->requireFlexibleForFreeSignup;
    }

    /**
     * @param array $response
     *
     * @return PackageObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'packageIdentifier'),
            static::getValueIsSet($response, 'serviceIdentifier'),
            static::getValueIsSet($response, 'displayNames', [], function ($value) {
                $displayNames = [];
                foreach ($value as $displayName) {
                    $displayNames[] = DisplayNameObject::fromResponse($displayName);
                }
                return $displayNames;
            }),
            static::getValueIsSet($response, 'signupAvailable'),
            static::getValueIsSet($response, 'addonPackages', [], function ($value) {
                $addonPackages = [];
                foreach ($value as $addonPackage) {
                    $addonPackages[] = PackageObject::fromResponse($addonPackage);
                }
                return $addonPackages;
            }),
            static::getValueIsSet($response, 'metaData', []),
            static::getValueIsSet($response, 'initialPeriod', null, function ($value) {
                return PackagePeriodObject::fromResponse($value);
            }),
            static::getValueIsSet($response, 'recurringPeriod', null, function ($value) {
                return PackagePeriodObject::fromResponse($value);
            }),
            static::getValueIsSet($response, 'hasTrialPeriod', false),
            static::getValueIsSet($response, 'billingMethods', [], function ($value) {
                $billingMethods = [];
                foreach ($value as $billingMethod) {
                    $billingMethods[] = BillingMethodObject::fromResponse($billingMethod);
                }
                return $billingMethods;
            }),
            static::getValueIsSet($response, 'requireFlexibleForFreeSignup', false)
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

        $billingMethods = [];
        foreach ($this->billingMethods as $billingMethod) {
            $billingMethods[] = $billingMethod->toArray();
        }

        return [
            '_type'                        => 'Package',
            'packageIdentifier'            => $this->packageIdentifier,
            'serviceIdentifier'            => $this->serviceIdentifier,
            'displayNames'                 => $displayNames,
            'signupAvailable'              => $this->signupAvailable,
            'addonPackages'                => $addonPackages,
            'metaData'                     => $this->metaData,
            'initialPeriod'                => $this->initialPeriod->toArray(),
            'recurringPeriod'              => $this->recurringPeriod
                ? $this->recurringPeriod->toArray()
                : null,
            'hasTrialPeriod'               => $this->hasTrialPeriod,
            'billingMethods'               => $billingMethods,
            'requireFlexibleForFreeSignup' => $this->requireFlexibleForFreeSignup,
        ];
    }

}