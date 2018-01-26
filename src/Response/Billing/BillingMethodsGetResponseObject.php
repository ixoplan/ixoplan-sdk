<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\BillingMethodObject;

/**
 * Class BillingMethodsGetResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingMethodsGetResponseObject {

    /**
     * @var BillingMethodObject[]
     */
    private $billingMethods;

    /**
     * @param BillingMethodObject[] $billingMethods
     */
    public function __construct($billingMethods) {
        $this->billingMethods = $billingMethods;
    }

    /**
     * @return BillingMethodObject[]
     */
    public function getBillingMethods() {
        return $this->billingMethods;
    }

    /**
     * @param array $response
     *
     * @return BillingMethodsGetResponseObject
     */
    public static function fromResponse(array $response) {
        $billingMethods = [];
        foreach ($response['billingMethods'] as $billingMethodDefinition) {
            $billingMethods[] = BillingMethodObject::fromResponse($billingMethodDefinition);
        }

        return new self($billingMethods);
    }

}