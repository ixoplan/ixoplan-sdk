<?php

namespace Ixolit\Dislo\Response\Misc;

/**
 * Class MiscMailTrackOpenedResponseObject
 *
 * @package Ixolit\Dislo\Response\Misc
 */
final class MiscMailTrackOpenedResponseObject {

    /**
     * @param $response
     *
     * @return self
     */
    public static function fromResponse($response) {
        return new self();
    }
}