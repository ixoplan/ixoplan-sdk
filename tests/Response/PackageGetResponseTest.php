<?php

use Ixolit\Dislo\Response\PackageGetResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\PackageMock;

/**
 * Class PackageGetResponseTest
 */
class PackageGetResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $package = PackageMock::create();

        $packageGetResponse = new PackageGetResponse($package);

        $reflectionObject = new \ReflectionObject($packageGetResponse);

        $packageProperty = $reflectionObject->getProperty('package');
        $packageProperty->setAccessible(true);
        $this->comparePackage($packageProperty->getValue($packageGetResponse), $package);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $package = PackageMock::create();

        $packageGetResponse = new PackageGetResponse($package);

        $this->comparePackage($packageGetResponse->getPackage(), $package);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $package = PackageMock::create();

        $packageGetResponse = PackageGetResponse::fromResponse($package->toArray());

        $this->comparePackage($packageGetResponse->getPackage(), $package);
    }

}