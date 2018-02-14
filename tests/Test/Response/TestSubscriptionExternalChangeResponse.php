<?php

namespace Ixolit\Dislo\Test\Response;


use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class TestSubscriptionExternalChangeResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestSubscriptionExternalChangeResponse implements TestResponseInterface {

    /**
     * @var int
     */
    private $upgradeId;

    /**
     * TestSubscriptionExternalChangeResponse constructor.
     */
    public function __construct() {
        $this->upgradeId = MockHelper::getFaker()->randomNumber();
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
            'upgradeId' => $this->getUpgradeId(),
        ];
    }

}