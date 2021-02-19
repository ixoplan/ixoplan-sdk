<?php

namespace Ixolit\Dislo\Response;

/**
 * Class SubscriptionValidateMetaDataResponse
 *
 * @package Ixolit\Dislo\Response
 */
final class SubscriptionValidateMetaDataResponse
{
    /**
     * @param array $response
     *
     * @return SubscriptionValidateMetaDataResponse
     */
    public static function fromResponse(array $response)
    {
        return new self();
    }
}
