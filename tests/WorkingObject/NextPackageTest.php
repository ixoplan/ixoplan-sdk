<?php
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\DisplayNameMock;
use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\Test\WorkingObjects\PackagePeriodMock;
use Ixolit\Dislo\WorkingObjects\DisplayName;
use Ixolit\Dislo\WorkingObjects\NextPackage;
use Ixolit\Dislo\WorkingObjects\Package;
use Ixolit\Dislo\WorkingObjects\PackagePeriod;
use Ixolit\Dislo\WorkingObjectsCustom\NextPackageCustom;

/**
 * Class NextPackageTest
 */
class NextPackageTest extends AbstractTestCase {

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

        $signupAvailable   = MockHelper::getFaker()->boolean();

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $metaData          = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $initialPeriod     = PackagePeriodMock::create();
        $recurringPeriod   = PackagePeriodMock::create();
        $paid              = MockHelper::getFaker()->boolean;
        $effectiveAt       = MockHelper::getFaker()->dateTime();

        $nextPackage = new NextPackage(
            $packageIdentifier,
            $serviceIdentifier,
            $displayNames,
            $signupAvailable,
            $addonPackages,
            $metaData,
            $initialPeriod,
            $recurringPeriod,
            $paid,
            $effectiveAt
        );

        $reflectionObject = new \ReflectionObject($nextPackage);

        $paidProperty = $reflectionObject->getProperty('paid');
        $paidProperty->setAccessible(true);
        $this->assertEquals($paid, $paidProperty->getValue($nextPackage));

        $effectiveAtProperty = $reflectionObject->getProperty('effectiveAt');
        $effectiveAtProperty->setAccessible(true);
        $this->assertEquals($effectiveAt, $effectiveAtProperty->getValue($nextPackage));

        $reflectionObject = $reflectionObject->getParentClass();

        $packageIdentifierProperty = $reflectionObject->getProperty('packageIdentifier');
        $packageIdentifierProperty->setAccessible(true);
        $this->assertEquals($packageIdentifier, $packageIdentifierProperty->getValue($nextPackage));

        $serviceIdentifierProperty = $reflectionObject->getProperty('serviceIdentifier');
        $serviceIdentifierProperty->setAccessible(true);
        $this->assertEquals($serviceIdentifier, $serviceIdentifierProperty->getValue($nextPackage));

        $displayNamesProperty = $reflectionObject->getProperty('displayNames');
        $displayNamesProperty->setAccessible(true);

        /** @var DisplayName[] $testDisplayNames */
        $testDisplayNames = $displayNamesProperty->getValue($nextPackage);
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($displayNames, $displayNamesProperty->getValue($nextPackage));

        $signupAvailableProperty = $reflectionObject->getProperty('signupAvailable');
        $signupAvailableProperty->setAccessible(true);
        $this->assertEquals($signupAvailable, $signupAvailableProperty->getValue($nextPackage));


        $addonPackagesProperty = $reflectionObject->getProperty('addonPackages');
        $addonPackagesProperty->setAccessible(true);

        /** @var Package[] $testAddonPackages */
        $testAddonPackages = $addonPackagesProperty->getValue($nextPackage);
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($addonPackages, $addonPackagesProperty->getValue($nextPackage));

        $metaDataProperty = $reflectionObject->getProperty('metaData');
        $metaDataProperty->setAccessible(true);
        $this->assertEquals($metaData, $metaDataProperty->getValue($nextPackage));

        $initialPeriodProperty = $reflectionObject->getProperty('initialPeriod');
        $initialPeriodProperty->setAccessible(true);
        $this->assertEquals($initialPeriod, $initialPeriodProperty->getValue($nextPackage));

        $recurringPeriodProperty = $reflectionObject->getProperty('recurringPeriod');
        $recurringPeriodProperty->setAccessible(true);
        $this->assertEquals($recurringPeriod, $recurringPeriodProperty->getValue($nextPackage));
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

        $signupAvailable   = MockHelper::getFaker()->boolean();

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $metaData          = [
            MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
        ];
        $initialPeriod     = PackagePeriodMock::create();
        $recurringPeriod   = PackagePeriodMock::create();
        $paid              = MockHelper::getFaker()->boolean;
        $effectiveAt       = MockHelper::getFaker()->dateTime();

        $nextPackage = new NextPackage(
            $packageIdentifier,
            $serviceIdentifier,
            $displayNames,
            $signupAvailable,
            $addonPackages,
            $metaData,
            $initialPeriod,
            $recurringPeriod,
            $paid,
            $effectiveAt
        );

        $this->assertEquals($paid, $nextPackage->isPaid());
        $this->assertEquals($effectiveAt, $nextPackage->getEffectiveAt());
    }

    public function testFromResponse() {
        $effectiveAt = MockHelper::getFaker()->dateTime();

        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $initialPeriod     = PackagePeriodMock::create();
        $recurringPeriod   = PackagePeriodMock::create();

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
            'addonPackages' => \array_map(
                function($addonPackage) {
                    /** @var Package $addonPackage */
                    return $addonPackage->toArray();
                },
                $addonPackages
            ),
            'metaData' => [
                MockHelper::getFaker()->uuid => MockHelper::getFaker()->word,
            ],
            'initialPeriod' => $initialPeriod->toArray(),
            'recurringPeriod' => $recurringPeriod->toArray(),
            'paid' => MockHelper::getFaker()->boolean(),
            'effectiveAt' => $effectiveAt->format('Y-m-d H:i:s'),
        ];

        $nextPackage = NextPackage::fromResponse($response);

        $this->assertEquals($response['packageIdentifier'], $nextPackage->getPackageIdentifier());
        $this->assertEquals($response['serviceIdentifier'], $nextPackage->getServiceIdentifier());

        /** @var DisplayName[] $testDisplayNames */
        $testDisplayNames = $nextPackage->getDisplayNames();
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($response['signupAvailable'], $nextPackage->isSignupAvailable());

        /** @var Package[] $testAddonPackages */
        $testAddonPackages = $nextPackage->getAddonPackages();
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($response['metaData'], $nextPackage->getMetaData());
        $this->comparePackagePeriod($nextPackage->getInitialPeriod(), $initialPeriod);
        $this->comparePackagePeriod($nextPackage->getRecurringPeriod(), $recurringPeriod);
        $this->assertEquals($response['paid'], $nextPackage->isPaid());
        $this->assertEquals($effectiveAt, $nextPackage->getEffectiveAt());
    }

    /**
     * @return void
     */
    public function testToArray() {
        $effectiveAt = MockHelper::getFaker()->dateTime();

        $displayName = DisplayNameMock::create();
        $displayNames      = [
            $displayName->getLanguage() => $displayName,
        ];

        $addonPackage = PackageMock::create();
        $addonPackages     = [
            $addonPackage->getPackageIdentifier() => $addonPackage,
        ];

        $initialPeriod     = PackagePeriodMock::create();
        $recurringPeriod   = PackagePeriodMock::create();

        $nextPackage = new NextPackage(
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
            MockHelper::getFaker()->boolean(),
            $effectiveAt
        );

        $nextPackageArray = $nextPackage->toArray();

        $this->assertEquals($nextPackage->getPackageIdentifier(), $nextPackageArray['packageIdentifier']);
        $this->assertEquals($nextPackage->getServiceIdentifier(), $nextPackageArray['serviceIdentifier']);

        $testDisplayNames = $nextPackageArray['displayNames'];
        $this->assertTrue(\is_array($testDisplayNames));
        foreach ($testDisplayNames as $testDisplayName) {
            $testDisplayName = DisplayName::fromResponse($testDisplayName);

            if (empty($displayNames[$testDisplayName->getLanguage()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->compareDisplayName($testDisplayName, $displayNames[$testDisplayName->getLanguage()]);
        }

        $this->assertEquals($nextPackage->isSignupAvailable(), $nextPackageArray['signupAvailable']);

        $testAddonPackages = $nextPackageArray['addonPackages'];
        $this->assertTrue(\is_array($testAddonPackages));
        foreach ($testAddonPackages as $testAddonPackage) {
            $testAddonPackage = Package::fromResponse($testAddonPackage);

            if (empty($addonPackages[$testAddonPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testAddonPackage, $addonPackages[$testAddonPackage->getPackageIdentifier()]);
        }

        $this->assertEquals($nextPackage->getMetaData(), $nextPackageArray['metaData']);
        $this->comparePackagePeriod(PackagePeriod::fromResponse($nextPackageArray['initialPeriod']), $initialPeriod);
        $this->comparePackagePeriod(PackagePeriod::fromResponse($nextPackageArray['recurringPeriod']), $recurringPeriod);
        $this->assertEquals($nextPackage->isPaid(), $nextPackageArray['paid']);
        $this->assertEquals($nextPackage->getEffectiveAt()->format('Y-m-d H:i:s'), $nextPackageArray['effectiveAt']);
    }

    /**
     * @return void
     */
    public function testCustomObject() {
        $nextPackage = new NextPackage(
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
            MockHelper::getFaker()->boolean(),
            MockHelper::getFaker()->dateTime()
        );

        $nextPackageCustomObject = $nextPackage->getCustom();

        $this->assertInstanceOf(NextPackageCustom::class, $nextPackageCustomObject);
    }

}