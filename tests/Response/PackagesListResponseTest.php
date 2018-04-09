<?php

use Ixolit\Dislo\Response\PackagesListResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;
use Ixolit\Dislo\WorkingObjects\Package;

/**
 * Class PackagesListResponseTest
 */
class PackagesListResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $package = PackageMock::create();
        $packages = [
            $package->getPackageIdentifier() => $package,
        ];

        $packagesListResponse = new PackagesListResponse($packages);

        $reflectionObject = new \ReflectionObject($packagesListResponse);

        $packagesProperty = $reflectionObject->getProperty('packages');
        $packagesProperty->setAccessible(true);

        /** @var Package[] $testPackages */
        $testPackages = $packagesProperty->getValue($packagesListResponse);
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$package->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$package->getPackageIdentifier()]);
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

        $packagesListResponse = new PackagesListResponse($packages);

        $testPackages = $packagesListResponse->getPackages();
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$package->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$package->getPackageIdentifier()]);
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
            'packages' => \array_map(
                function($package) {
                    /** @var Package $package */
                    return $package->toArray();
                },
                $packages
            )
        ];

        $packagesListResponse = PackagesListResponse::fromResponse($response);

        $testPackages = $packagesListResponse->getPackages();
        foreach ($testPackages as $testPackage) {
            if (empty($packages[$package->getPackageIdentifier()])) {
                $this->assertTrue(false);

                continue;
            }

            $this->comparePackage($testPackage, $packages[$package->getPackageIdentifier()]);
        }
    }

}