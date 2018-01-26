<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\PackageObject;

/**
 * Class SubscriptionGetPossiblePackageChangesResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionGetPossiblePackageChangesResponseObject {

    /**
     * @var PackageObject[]
     */
    private $packages = [];

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
     * @param $data
     *
     * @return SubscriptionGetPossiblePackageChangesResponseObject
     */
    public static function fromResponse($data) {
        $result = [];
        foreach ($data['plans'] as $plan) {
            $result[] = PackageObject::fromResponse($plan);
        }

        return new self($result);
    }

}