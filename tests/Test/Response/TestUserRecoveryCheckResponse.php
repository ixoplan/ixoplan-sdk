<?php

namespace Ixolit\Dislo\Test\Response;

use Ixolit\Dislo\Test\WorkingObjects\MockHelper;

/**
 * Class TestUserRecoveryCheckResponse
 *
 * @package Ixolit\Dislo\Test\Response
 */
class TestUserRecoveryCheckResponse implements TestResponseInterface {

    /**
     * @var bool
     */
    private $valid;

    /**
     * TestUserRecoveryCheckResponse constructor.
     */
    public function __construct() {
        $this->valid = MockHelper::getFaker()->boolean();
    }

    /**
     * @return bool
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * @param string $uri
     * @param array  $data
     *
     * @return array
     */
    public function handleRequest($uri, array $data = []) {
        return [
            'valid' => $this->isValid(),
        ];
    }

}