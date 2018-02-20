<?php

namespace Ixolit\Dislo\WorkingObjects\Billing;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;

/**
 * Class BillingMethodObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class BillingMethodObject extends AbstractWorkingObject {

    /**
     * @var int
     */
    private $billingMethodId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var bool|null
     */
    private $available;

    /**
     * @var bool|null
     */
    private $checkout;

    /**
     * @var bool|null
     */
    private $flexible;

    /**
     * @var bool|null
     */
    private $recurring;

    /**
     * @var bool|null
     */
    private $replaceable;

    /**
     * @param int    	$billingMethodId
     * @param string 	$name
     * @param string 	$displayName
     * @param bool|null $available
     * @param bool|null $checkout
     * @param bool|null $flexible
     * @param bool|null $recurring
     * @param bool|null $replaceable
     */
    public function __construct(
        $billingMethodId,
        $name,
        $displayName,
        $available = null,
        $checkout = null,
        $flexible = null,
        $recurring = null,
        $replaceable = null
    ) {
        $this->billingMethodId = $billingMethodId;
        $this->name            = $name;
        $this->displayName     = $displayName;
        $this->available       = $available;
        $this->checkout        = $checkout;
        $this->flexible        = $flexible;
        $this->recurring       = $recurring;
        $this->replaceable     = $replaceable;
    }

    /**
     * @return int
     */
    public function getBillingMethodId() {
        return $this->billingMethodId;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDisplayName() {
        return $this->displayName;
    }

    /**
     * @return bool|null
     */
    public function isAvailable() {
        return $this->available;
    }

    /**
     * @return bool|null
     */
    public function isCheckout() {
        return $this->checkout;
    }

    /**
     * @return bool|null
     */
    public function isFlexible() {
        return $this->flexible;
    }

    /**
     * @return bool|null
     */
    public function isRecurring() {
        return $this->recurring;
    }

    /**
     * @return bool|null
     */
    public function isReplaceable() {
        return $this->replaceable;
    }

    /**
     * @param array $response
     *
     * @return BillingMethodObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'billingMethodId'),
            static::getValueIsSet($response, 'name'),
            static::getValueIsSet($response, 'displayName'),
            static::getValueIsSet($response, 'available'),
            static::getValueIsSet($response, 'checkout'),
            static::getValueIsSet($response, 'flexible'),
            static::getValueIsSet($response, 'recurring'),
            static::getValueIsSet($response, 'replaceable')
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            '_type'           => 'BillingMethod',
            'billingMethodId' => $this->billingMethodId,
            'name'            => $this->name,
            'displayName'     => $this->displayName,
            'available'       => $this->available,
            'checkout'        => $this->checkout,
            'flexible'        => $this->flexible,
            'recurring'       => $this->recurring,
            'replaceable'     => $this->replaceable,
        ];
    }

}