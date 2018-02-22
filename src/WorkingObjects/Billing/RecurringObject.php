<?php

namespace Ixolit\Dislo\WorkingObjects\Billing;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjectsCustom\Billing\RecurringObjectCustom;

/**
 * Class RecurringObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class RecurringObject extends AbstractWorkingObject {

    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_CLOSED = 'closed';
    const STATUS_PENDING = 'pending';

    /**
     * @var int
     */
    private $recurringId;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $providerToken;

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $canceledAt;

    /**
     * @var \DateTime
     */
    private $closedAt;

    /**
     * @var string[]
     */
    private $parameters = [];

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var BillingMethodObject
     */
    private $billingMethod;

    /**
     * @param int                 $recurringId
     * @param string              $status
     * @param string              $providerToken
     * @param SubscriptionObject  $subscription
     * @param \DateTime           $createdAt
     * @param \DateTime|null      $canceledAt
     * @param \DateTime|null      $closedAt
     * @param string[]            $parameters
     * @param float               $amount
     * @param string              $currency
     * @param BillingMethodObject $billingMethod
     */
    public function __construct(
        $recurringId,
        $status,
        $providerToken,
        SubscriptionObject $subscription,
        \DateTime $createdAt,
        $canceledAt,
        $closedAt,
        $parameters,
        $amount,
        $currency,
        BillingMethodObject $billingMethod
    ) {
        $this->recurringId   = $recurringId;
        $this->status        = $status;
        $this->providerToken = $providerToken;
        $this->subscription  = $subscription;
        $this->createdAt     = $createdAt;
        $this->canceledAt    = $canceledAt;
        $this->closedAt      = $closedAt;
        $this->parameters    = $parameters;
        $this->amount        = $amount;
        $this->currency      = $currency;
        $this->billingMethod = $billingMethod;
        $this->addCustomObject();
    }

    /**
     * @return RecurringObjectCustom|null
     */
    public function getCustom() {
        /** @var RecurringObjectCustom $custom */
        $custom = ($this->getCustomObject() instanceof RecurringObjectCustom) ? $this->getCustomObject() : null;
        return $custom;
    }

    /**
     * @return int
     */
    public function getRecurringId() {
        return $this->recurringId;
    }

    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getProviderToken() {
        return $this->providerToken;
    }

    /**
     * @return SubscriptionObject
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCanceledAt() {
        return $this->canceledAt;
    }

    /**
     * @return \DateTime
     */
    public function getClosedAt() {
        return $this->closedAt;
    }

    /**
     * @return \string[]
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency() {
        return $this->currency;
    }

    /**
     * @return BillingMethodObject
     */
    public function getBillingMethod() {
        return $this->billingMethod;
    }

    /**
     * @param array $response
     *
     * @return RecurringObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'recurringId'),
            static::getValueIsSet($response, 'status'),
            static::getValueIsSet($response, 'providerToken'),
            static::getValueIsSet($response, 'providerToken', null, function ($value) {
                return SubscriptionObject::fromResponse($value);
            }),
            static::getValueAsDateTime($response, 'createdAt'),
            static::getValueAsDateTime($response, 'canceledAt'),
            static::getValueAsDateTime($response, 'closedAt'),
            static::getValueIsSet($response, 'parameters'),
            static::getValueIsSet($response, 'amount'),
            static::getValueIsSet($response, 'currency'),
            static::getValueIsSet($response, 'providerToken', null, function ($value) {
                return BillingMethodObject::fromResponse($value);
            })
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            '_type'         => 'Recurring',
            'recurringId'   => $this->recurringId,
            'status'        => $this->status,
            'providerToken' => $this->providerToken,
            'subscription'  => $this->subscription->toArray(),
            'createdAt'     => $this->createdAt->format('Y-m-d H:i:s'),
            'canceledAt'    => $this->canceledAt
                ? $this->canceledAt->format('Y-m-d H:i:s')
                : null,
            'closedAt'      => $this->closedAt
                ? $this->closedAt->format('Y-m-d H:i:s')
                : null,
            'parameters'    => $this->parameters,
            'amount'        => $this->amount,
            'currency'      => $this->currency,
            'billingMethod' => $this->billingMethod->toArray(),
        ];
    }

}