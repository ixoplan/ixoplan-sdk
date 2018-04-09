<?php

use Ixolit\Dislo\Response\SubscriptionGetPossibleUpgradesResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class SubscriptionGetPossibleUpgradesResponseTest
 */
class SubscriptionGetPossibleUpgradesResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $package = PackageMock::create();
        $packages = [
            $package->getPackageIdentifier() => $package,
        ];

        $subscriptionGetPossibleUpgradesResponse = new SubscriptionGetPossibleUpgradesResponse($packages);

        $reflectionObject = new \ReflectionObject($subscriptionGetPossibleUpgradesResponse);

        $packagesProperty = $reflectionObject->getProperty('packages');
        $packagesProperty->setAccessible(true);

        /** @var Package[] $testPackages */
        $testPackages = $packagesProperty->getValue($subscriptionGetPossibleUpgradesResponse);
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$testPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$testPackage->getPackageIdentifier()]);
        }
    }

    /**
     * @return void
     */
    public function testGetters() {
        $package = PackageMock::create();
        $packages = [
            $package->getPackageIdentifier() => $package,
        ];

        $subscriptionGetPossibleUpgradesResponse = new SubscriptionGetPossibleUpgradesResponse($packages);

        $testPackages = $subscriptionGetPossibleUpgradesResponse->getPackages();
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$testPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$testPackage->getPackageIdentifier()]);
        }
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $package = PackageMock::create();
        $packages = [
            $package->getPackageIdentifier() => $package,
        ];

        $response = [
            'plans' => \array_map(
                function($package) {
                    /** @var Package $package */
                    return $package->toArray();
                },
                $packages
            )
        ];

        $subscriptionGetPossibleUpgradesResponse = SubscriptionGetPossibleUpgradesResponse::fromResponse($response);

        $testPackages = $subscriptionGetPossibleUpgradesResponse->getPackages();
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$testPackage->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$testPackage->getPackageIdentifier()]);
        }
    }

}