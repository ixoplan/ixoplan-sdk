<?php

namespace Ixolit\Dislo\Response;


/**
 * Class SubscriptionExternalChangeResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionExternalChangeResponseObject {

    /**
     * @var int
     */
    private $upgradeId;

    /**
     * @param int $upgradeId
     */
    public function __construct($upgradeId) {
        $this->upgradeId = $upgradeId;
    }

    /**
     * @return int
     */
    public function getUpgradeId() {
        return $this->upgradeId;
    }

    /**
     * @param $response
     *
     * @return SubscriptionExternalChangeResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['upgradeId']);
    }

}