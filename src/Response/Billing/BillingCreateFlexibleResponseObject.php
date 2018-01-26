<?php

namespace Ixolit\Dislo\Response\Billing;


use Ixolit\Dislo\WorkingObjects\FlexibleObject;

/**
 * Class BillingCreateFlexibleResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class BillingCreateFlexibleResponseObject {

    /**
     * @var FlexibleObject
     */
    private $flexible;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @param FlexibleObject $flexible
     * @param string|null    $redirectUrl
     */
    public function __construct(FlexibleObject $flexible, $redirectUrl = null) {
        $this->flexible    = $flexible;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return FlexibleObject
     */
    public function getFlexible() {
        return $this->flexible;
    }

    /**
     * @return null|string
     */
    public function getRedirectUrl() {
        return $this->redirectUrl;
    }

    /**
     * @param array $response
     *
     * @return BillingCreateFlexibleResponseObject
     */
    public static function fromResponse($response) {
        return new BillingCreateFlexibleResponseObject(
            FlexibleObject::fromResponse($response['flexible']),
            isset($response['redirectUrl']) ? $response['redirectUrl'] : null
        );
    }

}