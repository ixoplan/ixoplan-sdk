<?php

namespace Ixolit\Dislo\Response;

/**
 * Class UserValidateMetaDataResponse
 *
 * @package Ixolit\Dislo\Response
 */
final class UserValidateMetaDataResponse
{
    /**
     * @param array $response
     *
     * @return UserValidateMetaDataResponse
     */
    public static function fromResponse(array $response)
    {
        return new self();
    }
}
