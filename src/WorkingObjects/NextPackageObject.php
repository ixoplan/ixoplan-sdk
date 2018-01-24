<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\Exceptions\ObjectNotFoundException;

/**
 * Class NextPackageObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class NextPackageObject implements WorkingObject {

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
    private $paid;

    /**
     * @var \DateTime
     */
    private $effectiveAt;

    /**
     * @param string                   $packageIdentifier
     * @param string                   $serviceIdentifier
     * @param DisplayNameObject[]      $displayNames
     * @param bool                     $signupAvailable
     * @param PackageObject[]          $addonPackages
     * @param string[]                 $metaData
     * @param PackagePeriodObject|null $initialPeriod
     * @param PackagePeriodObject|null $recurringPeriod
     * @param bool                     $paid
     * @param \DateTime                $effectiveAt
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
        $paid,
        \DateTime $effectiveAt
    ) {
        $this->packageIdentifier = $packageIdentifier;
        $this->serviceIdentifier = $serviceIdentifier;
        $this->displayNames      = $displayNames;
        $this->signupAvailable   = $signupAvailable;
        $this->addonPackages     = $addonPackages;
        $this->metaData          = $metaData;
        $this->initialPeriod     = $initialPeriod;
        $this->recurringPeriod   = $recurringPeriod;
        $this->paid              = $paid;
        $this->effectiveAt       = $effectiveAt;
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
     * @return NextPackageObject
     */
    public static function fromResponse($response) {
        $displayNames = [];
        foreach ($response['displayNames'] as $displayName) {
            $displayNames[] = DisplayNameObject::fromResponse($displayName);
        }
        $addonPackages = [];
        if(isset($response['addonPackages'])) {
            foreach ($response['addonPackages'] as $addonPackage) {
                $addonPackages[] = PackageObject::fromResponse($addonPackage);
            }
        }

        return new self(
            $response['packageIdentifier'],
            $response['serviceIdentifier'],
            $displayNames,
            $response['signupAvailable'],
            $addonPackages,
            isset($response['metaData'])
                ? $response['metaData']
                : array(),
            isset($response['initialPeriod']) && $response['initialPeriod']
                ? PackagePeriodObject::fromResponse($response['initialPeriod'])
                : null,
            isset($response['recurringPeriod']) && $response['recurringPeriod']
                ? PackagePeriodObject::fromResponse($response['recurringPeriod'])
                : null,
            $response['paid'],
            new \DateTime($response['effectiveAt'])
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
            '_type'             => 'Package',
            'packageIdentifier' => $this->packageIdentifier,
            'serviceIdentifier' => $this->serviceIdentifier,
            'displayNames'      => $displayNames,
            'signupAvailable'   => $this->signupAvailable,
            'addonPackages'     => $addonPackages,
            'metaData'          => $this->metaData,
            'initialPeriod'     => $this->initialPeriod->toArray(),
            'recurringPeriod'   => $this->recurringPeriod
                ? $this->recurringPeriod->toArray()
                : null,
            'paid'              => $this->paid,
            'effectiveAt'       => $this->effectiveAt->format('Y-m-d H:i:s'),
        ];
    }

}