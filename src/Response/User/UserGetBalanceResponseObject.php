<?php

namespace Ixolit\Dislo\Response\User;


use Ixolit\Dislo\WorkingObjects\PriceObject;

/**
 * Class UserGetBalanceResponseObject
 *
 * @package Ixolit\Dislo\Response
 */
final class UserGetBalanceResponseObject {

    /**
     * @var PriceObject
     */
    private $balance;

    /**
     * @param PriceObject $balance
     */
    public function __construct(PriceObject $balance) {
        $this->balance = $balance;
    }

    /**
     * @return PriceObject
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
        return new self(PriceObject::fromResponse($response['balance']));
    }

}