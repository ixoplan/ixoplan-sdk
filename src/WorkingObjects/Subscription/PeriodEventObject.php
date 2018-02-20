<?php

namespace Ixolit\Dislo\WorkingObjects\Subscription;


use Ixolit\Dislo\WorkingObjects\AbstractWorkingObject;
use Ixolit\Dislo\WorkingObjects\Billing\BillingEventObject;


/**
 * Class PeriodEventObject
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class PeriodEventObject extends AbstractWorkingObject {

    /**
     * @var int
     */
    private $periodEventId;

    /**
     * @var int
     */
    private $periodId;

    /**
     * @var int
     */
    private $subscriptionHistoryId;

    /**
     * @var \DateTime
     */
    private $startedAt;

    /**
     * @var \DateTime
     */
    private $endsAt;

    /**
     * @var int
     */
    private $parentPeriodEventId;

    /**
     * @var \DateTime
     */
    private $originalEndsAt;

    /**
     * @var BillingEventObject
     */
    private $billingEvent;

    /**
     * PeriodEvent constructor.
     *
     * @param int                     $periodEventId
     * @param int                     $periodId
     * @param int                     $subscriptionHistoryId
     * @param \DateTime|null          $startedAt
     * @param \DateTime|null          $endsAt
     * @param null                    $parentPeriodEventId
     * @param \DateTime|null          $originalEndsAt
     * @param BillingEventObject|null $billingEvent
     */
    public function __construct(
        $periodEventId,
        $periodId,
        $subscriptionHistoryId,
        \DateTime $startedAt = null,
        \DateTime $endsAt = null,
        $parentPeriodEventId = null,
        \DateTime $originalEndsAt = null,
        BillingEventObject $billingEvent = null
    ) {
        $this->periodEventId         = $periodEventId;
        $this->periodId              = $periodId;
        $this->subscriptionHistoryId = $subscriptionHistoryId;
        $this->startedAt             = $startedAt;
        $this->endsAt                = $endsAt;
        $this->parentPeriodEventId   = $parentPeriodEventId;
        $this->originalEndsAt        = $originalEndsAt;
        $this->billingEvent          = $billingEvent;
    }

    /**
     * @return int
     */
    public function getPeriodEventId() {
        return $this->periodEventId;
    }

    /**
     * @return int
     */
    public function getPeriodId() {
        return $this->periodId;
    }

    /**
     * @return int
     */
    public function getSubscriptionHistoryId() {
        return $this->subscriptionHistoryId;
    }

    /**
     * @return \DateTime
     */
    public function getStartedAt() {
        return $this->startedAt;
    }

    /**
     * @return \DateTime
     */
    public function getEndsAt() {
        return $this->endsAt;
    }

    /**
     * @return int
     */
    public function getParentPeriodEventId() {
        return $this->parentPeriodEventId;
    }

    /**
     * @return \DateTime
     */
    public function getOriginalEndsAt() {
        return $this->originalEndsAt;
    }

    /**
     * @return BillingEventObject
     */
    public function getBillingEvent() {
        return $this->billingEvent;
    }

    /**
     * @param array $response
     *
     * @return PeriodEventObject
     */
    public static function fromResponse($response) {
        return new self(
            static::getValue($response, 'id'),
            static::getValue($response, 'periodId'),
            static::getValue($response, 'subscriptionHistoryId'),
            static::getValueAsDateTime($response, 'startedAt'),
            static::getValueAsDateTime($response, 'endsAt'),
            static::getValue($response, 'parentPeriodEventId'),
            static::getValueAsDateTime($response, 'originalEndsAt'),
            static::getValue($response, 'billingEvent', null, function ($value) {
                return BillingEventObject::fromResponse($value);
            })
        );
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'id'                    => $this->periodEventId,
            'periodId'              => $this->periodId,
            'subscriptionHistoryId' => $this->subscriptionHistoryId,
            'startedAt'             => $this->startedAt
                ? $this->startedAt->format('Y-m-d H:i:s')
                : null,
            'endsAt'                => $this->endsAt
                ? $this->endsAt->format('Y-m-d H:i:s')
                : null,
            'parentPeriodEventId'   => $this->parentPeriodEventId,
            'originalEndsAt'        => $this->originalEndsAt
                ? $this->originalEndsAt->format('Y-m-d H:i:s')
                : null,
            'billingEvent'          => $this->billingEvent
                ? $this->billingEvent->toArray()
                : null,
        ];
    }

}