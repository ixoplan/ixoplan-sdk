<?php

use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\BillingMethodMock;
use Ixolit\Dislo\Test\WorkingObjects\DisplayNameMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\Test\WorkingObjects\PackagePeriodMock;
use Ixolit\Dislo\WorkingObjects\BillingMethod;
use Ixolit\Dislo\WorkingObjects\DisplayName;
use Ixolit\Dislo\WorkingObjects\Package;
use Ixolit\Dislo\WorkingObjects\PackagePeriod;
use Ixolit\Dislo\WorkingObjectsCustom\PackageCustom;

/**
 * Class PackageTest
 */
class PackageTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $packageIdentifier = MockHelper::getFaker()->uuid;
        $serviceIdentifier = MockHelper::getFaker()->uuid;

        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $signupAvailable = MockHelper::getFaker()->boolean();

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $metaData = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $initialPeriod = PackagePeriodMock::create();
        $recurringPeriod = PackagePeriodMock::create();
        $hasTrialPeriod = MockHelper::getFaker()->boolean;

        $billingMethod = BillingMethodMock::create();
        $billingMethods     = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $requireFlexibleForFreeSignup = MockHelper::getFaker()->boolean();

        $package = new Package(
            $packageIdentifier,
            $serviceIdentifier,
            $displayNames,
            $signupAvailable,
            $addonPackages,
            $metaData,
            $initialPeriod,
            $recurringPeriod,
            $hasTrialPeriod,
            $billingMethods,
            $requireFlexibleForFreeSignup
        );

        $reflectionObject = new \ReflectionObject($package);

        $packageIdentifierProperty = $reflectionObject->getProperty('packageIdentifier');
        $packageIdentifierProperty->setAccessible(true);
        $this->assertEquals($packageIdentifier, $packageIdentifierProperty->getValue($package));

        $serviceIdentifierProperty = $reflectionObject->getProperty('serviceIdentifier');
        $serviceIdentifierProperty->setAccessible(true);
        $this->assertEquals($serviceIdentifier, $serviceIdentifierProperty->getValue($package));

        $displayNamesProperty = $reflectionObject->getProperty('displayNames');
        $displayNamesProperty->setAccessible(true);

        /** @var DisplayName[] $testDisplayNames */
        $testDisplayNames = $displayNamesProperty->getValue($package);
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($displayNames, $displayNamesProperty->getValue($package));

        $signupAvailableProperty = $reflectionObject->getProperty('signupAvailable');
        $signupAvailableProperty->setAccessible(true);
        $this->assertEquals($signupAvailable, $signupAvailableProperty->getValue($package));


        $addonPackagesProperty = $reflectionObject->getProperty('addonPackages');
        $addonPackagesProperty->setAccessible(true);

        /** @var Package[] $testAddonPackages */
        $testAddonPackages = $addonPackagesProperty->getValue($package);
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($addonPackages, $addonPackagesProperty->getValue($package));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($package));

        $initialPeriodProperty = $reflectionObject->getProperty('initialPeriod');
        $initialPeriodProperty->setAccessible(true);
        $this->assertEquals($initialPeriod, $initialPeriodProperty->getValue($package));

        $recurringPeriodProperty = $reflectionObject->getProperty('recurringPeriod');
        $recurringPeriodProperty->setAccessible(true);
        $this->assertEquals($recurringPeriod, $recurringPeriodProperty->getValue($package));

        $hasTrialPeriodProperty = $reflectionObject->getProperty('hasTrialPeriod');
        $hasTrialPeriodProperty->setAccessible(true);
        $this->assertEquals($hasTrialPeriod, $hasTrialPeriodProperty->getValue($package));

        $requireFlexibleForFreeSignupProperty = $reflectionObject->getProperty('requireFlexibleForFreeSignup');
        $requireFlexibleForFreeSignupProperty->setAccessible(true);
        $this->assertEquals($requireFlexibleForFreeSignup, $requireFlexibleForFreeSignupProperty->getValue($package));

        $billingMethodsProperty = $reflectionObject->getProperty('billingMethods');
        $billingMethodsProperty->setAccessible(true);

        /** @var BillingMethod[] $testBillingMethods */
        $testBillingMethods = $billingMethodsProperty->getValue($package);
        $this->assertTrue(\is_array($testBillingMethods));
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $packageIdentifier = MockHelper::getFaker()->uuid;
        $serviceIdentifier = MockHelper::getFaker()->uuid;

        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $signupAvailable = MockHelper::getFaker()->boolean();

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $metaDataName = MockHelper::getFaker()->uuid;
        $metaDataEntry = MockHelper::getFaker()->word;

        $metaData = [
            $metaDataName => $metaDataEntry,
        ];
        $initialPeriod = PackagePeriodMock::create();
        $recurringPeriod = PackagePeriodMock::create();
        $hasTrialPeriod = MockHelper::getFaker()->boolean;

        $billingMethod = BillingMethodMock::create();
        $billingMethods     = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $requireFlexibleForFreeSignup = MockHelper::getFaker()->boolean();

        $package = new Package(
            $packageIdentifier,
            $serviceIdentifier,
            $displayNames,
            $signupAvailable,
            $addonPackages,
            $metaData,
            $initialPeriod,
            $recurringPeriod,
            $hasTrialPeriod,
            $billingMethods,
            $requireFlexibleForFreeSignup
        );

        $this->assertEquals($packageIdentifier, $package->getPackageIdentifier());
        $this->assertEquals($serviceIdentifier, $package->getServiceIdentifier());

        /** @var DisplayName[] $testDisplayNames */
        $testDisplayNames = $package->getDisplayNames();
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->compareDisplayName($package->getDisplayNameForLanguage($displayName->getLanguage()), $displayName);

        $this->assertEquals($signupAvailable, $package->isSignupAvailable());

        /** @var Package[] $testAddonPackages */
        $testAddonPackages = $package->getAddonPackages();
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($metaData, $package->getMetaData());
        $this->assertEquals($metaDataEntry, $package->getMetaDataEntry($metaDataName));

        $this->comparePackagePeriod($package->getInitialPeriod(), $initialPeriod);
        $this->comparePackagePeriod($package->getRecurringPeriod(), $recurringPeriod);
        $this->assertEquals($hasTrialPeriod, $package->hasTrialPeriod());

        /** @var BillingMethod[] $testBillingMethods */
        $testBillingMethods = $package->getBillingMethods();
        $this->assertTrue(\is_array($testBillingMethods));
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }

        $this->assertEquals($requireFlexibleForFreeSignup, $package->requiresFlexibleForFreeSignup());
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $metaDataName = MockHelper::getFaker()->uuid;
        $metaDataEntry = MockHelper::getFaker()->word;

        $metaData = [
            $metaDataName => $metaDataEntry,
        ];
        $initialPeriod = PackagePeriodMock::create();
        $recurringPeriod = PackagePeriodMock::create();

        $billingMethod = BillingMethodMock::create();
        $billingMethods     = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $response = [
            'packageIdentifier' => MockHelper::getFaker()->uuid,
            'serviceIdentifier' => MockHelper::getFaker()->uuid,
            'displayNames' => \array_map(
                function($displayName) {
                    /** @var DisplayName $displayName */
                    return $displayName->toArray();
                },
                $displayNames
            ),
            'signupAvailable' => MockHelper::getFaker()->boolean(),
            'requireFlexibleForFreeSignup' => MockHelper::getFaker()->boolean(),
            'addonPackages' => \array_map(
                function($addonPackage) {
                    /** @var Package $addonPackage */
                    return $addonPackage->toArray();
                },
                $addonPackages
            ),
            'metaData' => $metaData,
            'initialPeriod' => $initialPeriod->toArray(),
            'recurringPeriod' => $recurringPeriod->toArray(),
            'hasTrialPeriod' => MockHelper::getFaker()->boolean,
            'billingMethods' => \array_map(
                function($billingMethod) {
                    /** @var BillingMethod $billingMethod */
                    return $billingMethod->toArray();
                },
                $billingMethods
            ),
        ];

        $package = Package::fromResponse($response);

        $this->assertEquals($response['packageIdentifier'], $package->getPackageIdentifier());
        $this->assertEquals($response['serviceIdentifier'], $package->getServiceIdentifier());

        /** @var DisplayName[] $testDisplayNames */
        $testDisplayNames = $package->getDisplayNames();
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($response['signupAvailable'], $package->isSignupAvailable());

        /** @var Package[] $testAddonPackages */
        $testAddonPackages = $package->getAddonPackages();
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($response['metaData'], $package->getMetaData());

        $this->comparePackagePeriod($package->getInitialPeriod(), $initialPeriod);
        $this->comparePackagePeriod($package->getRecurringPeriod(), $recurringPeriod);
        $this->assertEquals($response['hasTrialPeriod'], $package->hasTrialPeriod());

        /** @var BillingMethod[] $testBillingMethods */
        $testBillingMethods = $package->getBillingMethods();
        $this->assertTrue(\is_array($testBillingMethods));
        foreach ($testBillingMethods as $testBillingMethod) {
            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }

        $this->assertEquals($response['requireFlexibleForFreeSignup'], $package->requiresFlexibleForFreeSignup());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $initialPeriod = PackagePeriodMock::create();
        $recurringPeriod = PackagePeriodMock::create();

        $billingMethod = BillingMethodMock::create();
        $billingMethods     = [
            $billingMethod->getBillingMethodId() => $billingMethod,
        ];

        $package = new Package(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            $displayNames,
            MockHelper::getFaker()->boolean(),
            $addonPackages,
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            $initialPeriod,
            $recurringPeriod,
            MockHelper::getFaker()->boolean,
            $billingMethods,
            MockHelper::getFaker()->boolean()
        );

        $packageArray = $package->toArray();

        $this->assertEquals($package->getPackageIdentifier(), $packageArray['packageIdentifier']);
        $this->assertEquals($package->getServiceIdentifier(), $packageArray['serviceIdentifier']);

        $testDisplayNames = $packageArray['displayNames'];
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            $testDisplayName = DisplayName::fromResponse($testDisplayName);

            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($package->isSignupAvailable(), $packageArray['signupAvailable']);

        $testAddonPackages = $packageArray['addonPackages'];
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            $testAddonPackage = Package::fromResponse($testAddonPackage);

            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($package->getMetaData(), $packageArray['metaData']);

        $this->comparePackagePeriod(PackagePeriod::fromResponse($packageArray['initialPeriod']), $initialPeriod);
        $this->comparePackagePeriod(PackagePeriod::fromResponse($packageArray['recurringPeriod']), $recurringPeriod);
        $this->assertEquals($package->hasTrialPeriod(), $packageArray['hasTrialPeriod']);

        $testBillingMethods = $packageArray['billingMethods'];
        $this->assertTrue(\is_array($testBillingMethods));
        foreach ($testBillingMethods as $testBillingMethod) {
            $testBillingMethod = BillingMethod::fromResponse($testBillingMethod);

            if (empty($billingMethods[$testBillingMethod->getBillingMethodId()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareBillingMethod($testBillingMethod, $billingMethods[$testBillingMethod->getBillingMethodId()]);
        }

        $this->assertEquals($package->requiresFlexibleForFreeSignup(), $packageArray['requireFlexibleForFreeSignup']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $package = new Package(
            MockHelper::getFaker()->uuid,
            MockHelper::getFaker()->uuid,
            [
                DisplayNameMock::create(),
            ],
            MockHelper::getFaker()->boolean(),
            [
                PackageMock::create(),
            ],
            [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            PackagePeriodMock::create(),
            PackagePeriodMock::create(),
            MockHelper::getFaker()->boolean,
            [
                BillingMethodMock::create(),
            ],
            MockHelper::getFaker()->boolean()
        );

        $packageCustomObject = $package->getCustom();

        $this->assertInstanceOf(PackageCustom::class, $packageCustomObject);
    }

}