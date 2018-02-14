<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\Subscription\PriceObject;

/**
 * Class UserGetBalanceResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserGetBalanceResponseObject {

    /**
     * @var PriceObject|null
     */
    private $balance;

    /**
     * @param PriceObject|null $balance
     */
    public function __construct(PriceObject $balance = null) {
        $this->balance = $balance;
    }

    /**
     * @return PriceObject|null
     */
    public function getBalance() {
        return $this->balance;
    }

    /**
     * @param array $response
     *
     * @return UserGetBalanceResponseObject
     */
    public static function fromResponse($response) {
        return new self(
            !empty($response['balance'])
                ? PriceObject::fromResponse($response['balance'])
                : null
        );
    }

}