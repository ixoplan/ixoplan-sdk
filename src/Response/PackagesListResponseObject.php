<?php

namespace Ixolit\Dislo\Response;


use Ixolit\Dislo\WorkingObjects\PackageObject;

/**
 * Class PackagesListResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class PackagesListResponseObject {

    /**
     * @var PackageObject[]
     */
    private $packages;

    /**
     * @param PackageObject[] $packages
     */
    public function __construct(array $packages) {
        $this->packages = $packages;
    }

    /**
     * @return PackageObject[]
     */
    public function getPackages() {
        return $this->packages;
    }

    /**
     * @param $response
     *
     * @return PackagesListResponseObject
     */
    public static function fromResponse($response) {
        $packages = [];
        foreach ($response['packages'] as $packageDefinition) {
            $packages[] = PackageObject::fromResponse($packageDefinition);
        }
        return new self($packages);
    }

}