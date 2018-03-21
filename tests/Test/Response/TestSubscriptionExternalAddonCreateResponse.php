<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;
use Ixolit\Dislo\Test\WorkingObjects\SubscriptionMock;
use Ixolit\Dislo\WorkingObjects\Subscription;

/**
 * Class TestSubscriptionExternalAddonCreateResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionExternalAddonCreateResponse implements TestResponseInterface {

    /**
     * @var Subscription
     */
    private $subscription;

    /**
     * @var int
     */
    private $upgradeId;

    public function __construct() {
        $this->subscription = SubscriptionMock::create();
        $this->upgradeId = MockHelper::getFaker()->randomNumber();
    }

    /**
     * @return Subscription
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
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'subscription' => $this->getSubscription()->toArray(),
            'upgradeId'    => $this->getUpgradeId(),
        ];
    }
}