<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\PackageObject;

/**
 * Class PackageGetResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class PackageGetResponseObject {

    /**
     * @var PackageObject
     */
    private $package;

    /**
     * @param PackageObject $package
     */
    public function __construct(PackageObject $package) {
        $this->package = $package;
    }

    /**
     * @return PackageObject
     */
    public function getPackage() {
        return $this->package;
    }

    /**
     * @param $response
     *
     * @return PackageGetResponseObject
     */
    public static function fromResponse($response) {
        return new self(PackageObject::fromResponse($response));
    }

}