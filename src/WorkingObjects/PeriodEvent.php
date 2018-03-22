<?php

namespace Ixolit\Dislo\WorkingObjects;


use Ixolit\Dislo\WorkingObjectsCustom\PeriodEventCustom;

/**
 * Class PeriodEvent
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
class PeriodEvent extends AbstractWorkingObject {

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
     * @var BillingEvent
     */
    private $billingEvent;

    /**
     * PeriodEvent constructor.
     *
     * @param int               $periodEventId
     * @param int               $periodId
     * @param int               $subscriptionHistoryId
     * @param \DateTime|null    $startedAt
     * @param \DateTime|null    $endsAt
     * @param null              $parentPeriodEventId
     * @param \DateTime|null    $originalEndsAt
     * @param BillingEvent|null $billingEvent
     */
    public function __construct(
        $periodEventId,
        $periodId,
        $subscriptionHistoryId,
        \DateTime $startedAt = null,
        \DateTime $endsAt = null,
        $parentPeriodEventId = null,
        \DateTime $originalEndsAt = null,
        BillingEvent $billingEvent = null
    ) {
        $this->periodEventId         = $periodEventId;
        $this->periodId              = $periodId;
        $this->subscriptionHistoryId = $subscriptionHistoryId;
        $this->startedAt             = $startedAt;
        $this->endsAt                = $endsAt;
        $this->parentPeriodEventId   = $parentPeriodEventId;
        $this->originalEndsAt        = $originalEndsAt;
        $this->billingEvent          = $billingEvent;

        $this->addCustomObject();
    }

    /**
     * @return PeriodEventCustom|null
     */
    public function getCustom() {
        /** @var PeriodEventCustom $custom */
        $custom = ($this->getCustomObject() instanceof PeriodEventCustom)
            ? $this->getCustomObject()
            : null;

        return $custom;
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
     * @return BillingEvent
     */
    public function getBillingEvent() {
        return $this->billingEvent;
    }

    /**
     * @param array $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        return new self(
            static::getValueIsSet($response, 'id'),
            static::getValueIsSet($response, 'periodId'),
            static::getValueIsSet($response, 'subscriptionHistoryId'),
            static::getValueAsDateTime($response, 'startedAt'),
            static::getValueAsDateTime($response, 'endsAt'),
            static::getValueIsSet($response, 'parentPeriodEventId'),
            static::getValueAsDateTime($response, 'originalEndsAt'),
            static::getValueIsSet($response, 'billingEvent', null, function ($value) {
                return BillingEvent::fromResponse($value);
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
            'startedAt'             => $this->startedAt ? $this->startedAt->format('Y-m-d H:i:s') : null,
            'endsAt'                => $this->endsAt ? $this->endsAt->format('Y-m-d H:i:s') : null,
            'parentPeriodEventId'   => $this->parentPeriodEventId,
            'originalEndsAt'        => $this->originalEndsAt ? $this->originalEndsAt->format('Y-m-d H:i:s') : null,
            'billingEvent'          => $this->billingEvent ? $this->billingEvent->toArray() : null,
        ];
    }

}