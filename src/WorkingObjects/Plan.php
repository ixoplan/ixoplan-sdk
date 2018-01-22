<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\Exceptions\ObjectNotFoundException;


/**
 * Class Plan
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class Plan implements WorkingObject {

    /**
     * @var string
     */
    private $planIdentifier;
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
     * @var Plan[]
     */
    private $addonPlans;
    /**
     * @var string[]
     */
    private $metaData;
    /**
     * @var PlanPeriod
     */
    private $initialPeriod;
    /**
     * @var PlanPeriod|null
     */
    private $recurringPeriod;

    /** @var bool */
    private $hasTrialPeriod;

    /** @var BillingMethod[] */
    private $billingMethods;

    /** @var bool */
    private $requireFlexibleForFreeSignup;

    /**
     * @param string          $planIdentifier
     * @param string          $serviceIdentifier
     * @param DisplayName[]   $displayNames
     * @param bool            $signupAvailable
     * @param Plan[]          $addonPlans
     * @param string[]        $metaData
     * @param PlanPeriod|null $initialPeriod
     * @param PlanPeriod|null $recurringPeriod
     * @param bool            $hasTrialPeriod
     * @param BillingMethod[] $billingMethods
     * @param bool            $requireFlexibleForFreeSignup
     */
    public function __construct(
        $planIdentifier,
        $serviceIdentifier,
        $displayNames,
        $signupAvailable,
        $addonPlans,
        $metaData,
        $initialPeriod,
        $recurringPeriod,
        $hasTrialPeriod = false,
        $billingMethods = null,
        $requireFlexibleForFreeSignup = false
    ) {
        $this->planIdentifier               = $planIdentifier;
        $this->serviceIdentifier            = $serviceIdentifier;
        $this->displayNames                 = $displayNames;
        $this->signupAvailable              = $signupAvailable;
        $this->addonPlans                   = $addonPlans;
        $this->metaData                     = $metaData;
        $this->initialPeriod                = $initialPeriod;
        $this->recurringPeriod              = $recurringPeriod;
        $this->hasTrialPeriod               = $hasTrialPeriod;
        $this->billingMethods               = $billingMethods;
        $this->requireFlexibleForFreeSignup = $requireFlexibleForFreeSignup;
    }

    /**
     * @return string
     */
    public function getPlanIdentifier() {
        return $this->planIdentifier;
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
            $this->planIdentifier);
    }

    /**
     * @return boolean
     */
    public function isSignupAvailable() {
        return $this->signupAvailable;
    }

    /**
     * @return Plan[]
     */
    public function getAddonPlans() {
        return $this->addonPlans;
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
     * @return PlanPeriod|null
     */
    public function getInitialPeriod() {
        return $this->initialPeriod;
    }

    /**
     * @return PlanPeriod|null
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
     * @return BillingMethod[]
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
     * @return self
     */
    public static function fromResponse($response) {
        $displayNames = [];
        foreach ($response['displayNames'] as $displayName) {
            $displayNames[] = DisplayName::fromResponse($displayName);
        }
        $addonPlans = [];
        if(isset($response['addonPackages'])) {
            foreach ($response['addonPackages'] as $addonPlan) {
                $addonPlans[] = Plan::fromResponse($addonPlan);
            }
        }

        $billingMethods = [];
        if(isset($response['billingMethods'])) {
            foreach ($response['billingMethods'] as $billingMethod) {
                $billingMethods[] = BillingMethod::fromResponse($billingMethod);
            }
        }

        return new Plan(
            $response['packageIdentifier'],
            $response['serviceIdentifier'],
            $displayNames,
            $response['signupAvailable'],
            $addonPlans,
            isset($response['metaData'])
                ? $response['metaData']
                : [],
            (isset($response['initialPeriod']) && $response['initialPeriod'])
                ? PlanPeriod::fromResponse($response['initialPeriod'])
                : null,
            (isset($response['recurringPeriod']) && $response['recurringPeriod'])
                ? PlanPeriod::fromResponse($response['recurringPeriod'])
                : null,
            isset($response['hasTrialPeriod'])
                ? $response['hasTrialPeriod']
                : false,
            $billingMethods,
            isset($response['requireFlexibleForFreeSignup'])
                ? $response['requireFlexibleForFreeSignup']
                : false
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

        $addonPlans = [];
        foreach ($this->addonPlans as $addonPlan) {
            $addonPlans[] = $addonPlan->toArray();
        }

        $billingMethods = [];
        foreach ($this->billingMethods as $billingMethod) {
            $billingMethods[] = $billingMethod->toArray();
        }

        return [
            '_type'                        => 'Package',
            'packageIdentifier'            => $this->getPlanIdentifier(),
            'serviceIdentifier'            => $this->getServiceIdentifier(),
            'displayNames'                 => $this->getDisplayNames(),
            'signupAvailable'              => $this->isSignupAvailable(),
            'addonPackages'                => $addonPlans,
            'metaData'                     => $this->getMetaData(),
            'initialPeriod'                => $this->getInitialPeriod()->toArray(),
            'recurringPeriod'              => !empty($this->getRecurringPeriod())
                ? $this->getRecurringPeriod()->toArray()
                : null,
            'hasTrialPeriod'               => $this->hasTrialPeriod(),
            'billingMethods'               => $billingMethods,
            'requireFlexibleForFreeSignup' => $this->requiresFlexibleForFreeSignup(),
        ];
    }

}