<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class PackageMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class PackageMock {

    /**
     * @param null $signupAvailable
     * @param bool $withAddonPackages
     *
     * @return Package
     */
    public static function create($signupAvailable = null, $withAddonPackages = true) {
        $displayName = DisplayNameMock::create();

        $addonPackages = [];
        if ($withAddonPackages) {
            $addonPackage = self::create($signupAvailable, false);

            $addonPackages[$addonPackage->getPackageIdentifier()] = $addonPackage;
        }

        $billingMethod = BillingMethodMock::create();

        return new Package(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                $displayName->getName() => $displayName,
            ],
            \is_null($signupAvailable)
                ? MockHelper::getFaker()->boolean()
                : $signupAvailable,
            $addonPackages,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            PackagePeriodMock::create(),
            PackagePeriodMock::create(),
            MockHelper::getFaker()->boolean(),
            [
                $billingMethod->getBillingMethodId() => $billingMethod,
            ],
            MockHelper::getFaker()->boolean()
        );
    }

}