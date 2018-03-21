<?php

namespace Ixolit\Dislo\Test\WorkingObjects;


use Ixolit\Dislo\WorkingObjects\NextPackage;

/**
 * Class NextPackageMock
 *
 * @package Ixolit\Dislo\Test\WorkingObjects
 */
class NextPackageMock {

    /**
     * @param bool $withAddonPackages
     *
     * @return NextPackage
     */
    public static function create($withAddonPackages = true) {
        $displayName = DisplayNameMock::create();

        $addonPackages = [];
        if ($withAddonPackages) {
            $addonPackage = PackageMock::create(null,false);

            $addonPackages[$addonPackage->getPackageIdentifier()] = $addonPackage;
        }

        return new NextPackage(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                $displayName->getName() => $displayName,
            ],
            true,
            $addonPackages,
            [
                MockHelper::getFaker()->word => MockHelper::getFaker()->word,
            ],
            PackagePeriodMock::create(),
            PackagePeriodMock::create(),
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->dateTime()
        );
    }

}