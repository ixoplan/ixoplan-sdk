<?php

namespace Ixolit\Dislo\Response\Subscription;


use Ixolit\Dislo\WorkingObjects\SubscriptionObject;

/**
 * Class SubscriptionExternalAddonCreateResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionExternalAddonCreateResponseObject {

    /**
     * @var SubscriptionObject
     */
    private $subscription;

    /**
     * @var int
     */
    private $upgradeId;

    /**
     * @param SubscriptionObject $subscription
     * @param int                $upgradeId
     */
    public function __construct(SubscriptionObject $subscription, $upgradeId) {
        $this->subscription = $subscription;
        $this->upgradeId    = $upgradeId;
    }

    /**
     * @return SubscriptionObject
     */
    public function getSubscription() {
        return $this->subscription;
    }

    /**
     * @return int
     */
    public function getUpgradeId() {
        return $this->upgradeId;
    }

    /**
     * @param array $response
     *
     * @return SubscriptionExternalAddonCreateResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            SubscriptionObject::fromResponse($response['subscription']),
            $response['upgradeId']
        );
    }

}