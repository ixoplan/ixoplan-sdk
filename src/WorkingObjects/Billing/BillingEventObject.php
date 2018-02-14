<?php

namespace Ixolit\Dislo\WorkingObjects\Billing;


use Ixolit\Dislo\WorkingObjects\Subscription\SubscriptionObject;
use Ixolit\Dislo\WorkingObjects\WorkingObject;

/**
 * Class BillingEventObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class BillingEventObject implements WorkingObject {

    const TYPE_AUTHORIZE = 'authorize';
    const TYPE_CHARGE = 'charge';
    const TYPE_REFUND = 'refund';
    const TYPE_CHARGEBACK = 'chargeback';

    const STATUS_REQUESTED = 'requested';
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    /**
     * @var int
     */
    private $billingEventId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $currencyCode;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $description;

    /**
     * @var null|string
     */
    private $techinfo;

    /**
     * @var string
     */
    private $billingMethod;

    /**
     * @var SubscriptionObject|null
     */
    private $subscription;

    /**
     * @var \DateTime|null
     */
    private $modifiedAt;

    /**
     * @var BillingMethodObject
     */
    private $billingMethodObject;

    /**
     * BillingEvent constructor.
     *
     * @param int                      $billingEventId
     * @param int                      $userId
     * @param string                   $currencyCode
     * @param float                    $amount
     * @param \DateTime                $createdAt
     * @param string                   $type
     * @param string                   $status
     * @param string                   $description
     * @param string|null              $techinfo
     * @param string                   $billingMethod
     * @param SubscriptionObject|null  $subscription
     * @param \DateTime|null           $modifiedAt
     * @param BillingMethodObject|null $billingMethodObject
     */
    public function __construct(
        $billingEventId,
        $userId,
        $currencyCode,
        $amount,
        \DateTime $createdAt,
        $type,
        $status,
        $description,
        $techinfo,
        $billingMethod,
        SubscriptionObject $subscription = null,
        $modifiedAt = null,
        BillingMethodObject $billingMethodObject = null
    ) {
        $this->billingEventId      = $billingEventId;
        $this->userId              = $userId;
        $this->currencyCode        = $currencyCode;
        $this->amount              = $amount;
        $this->createdAt           = $createdAt;
        $this->type                = $type;
        $this->status              = $status;
        $this->description         = $description;
        $this->techinfo            = $techinfo;
        $this->billingMethod       = $billingMethod;
        $this->subscription        = $subscription;
        $this->modifiedAt          = $modifiedAt;
        $this->billingMethodObject = $billingMethodObject;
    }

    /**
     * @return int
     */
    public function getBillingEventId() {
        return $this->billingEventId;
    }

    /**
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCurrencyCode() {
        return $this->currencyCode;
    }

    /**
     * @return float
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
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
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return null|string
     */
    public function getTechinfo() {
        return $this->techinfo;
    }

    /**
     * @return string
     */
    public function getBillingMethod() {
        return $this->billingMethod;
    }

    /**
     * @return SubscriptionObject|null
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return \DateTime|null
     */
    public function getModifiedAt() {
        return $this->modifiedAt;
    }

    /**
     * @return BillingMethodObject
     */
    public function getBillingMethodObject() {
        return $this->billingMethodObject;
    }

    /**
     * @param array $response
     *
     * @return BillingEventObject
     */
    public static function fromResponse($response) {
        return new self(
            $response['billingEventId'],
            $response['userId'],
            $response['currencyCode'],
            $response['amount'],
            new \DateTime($response['createdAt']),
            $response['type'],
            $response['status'],
            $response['description'],
            $response['techinfo'],
            $response['billingMethod'],
            !empty($response['subscription'])
                ? SubscriptionObject::fromResponse($response['subscription'])
                : null,
            !empty($response['modifiedAt'])
                ? new \DateTime($response['modifiedAt'])
                : null,
            !empty($response['billingMethodObject'])
                ? BillingMethodObject::fromResponse($response['billingMethodObject'])
                : null
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            '_type'               => 'BillingEvent',
            'billingEventId'      => $this->billingEventId,
            'userId'              => $this->userId,
            'currencyCode'        => $this->currencyCode,
            'amount'              => $this->amount,
            'createdAt'           => $this->createdAt->format('Y-m-d H:i:s'),
            'type'                => $this->type,
            'status'              => $this->status,
            'description'         => $this->description,
            'techinfo'            => $this->techinfo,
            'billingMethod'       => $this->billingMethod,
            'subscription'        => $this->subscription
                ? $this->subscription->toArray()
                : null,
            'modifiedAt'          => $this->modifiedAt
                ? $this->modifiedAt->format('Y-m-d H:i:s')
                : null,
            'billingMethodObject' => $this->billingMethodObject
                ? $this->billingMethodObject->toArray()
                : null,
        ];
    }

}