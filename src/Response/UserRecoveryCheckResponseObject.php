<?php

namespace Ixolit\Dislo\Response;


/**
 * Class UserRecoveryCheckResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserRecoveryCheckResponseObject {

    /**
     * @var bool
     */
    private $valid;

    /**
     * @param bool $valid
     */
    public function __construct($valid) {
        $this->valid = $valid;
    }

    /**
     * @return boolean
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * @param array $response
     *
     * @return UserRecoveryCheckResponseObject
     */
    public static function fromResponse($response) {
        return new self($response['valid']);
    }

}