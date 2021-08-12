<?php

namespace Ixolit\Dislo\WorkingObjects;

/**
 * Class Currency
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class Currency implements WorkingObject
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $symbol;

    /**
     * Currency constructor.
     *
     * @param string $code
     * @param string $symbol
     */
    public function __construct($code, $symbol)
    {
        $this->code = $code;
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param array $response
     *
     * @return Currency
     */
    public static function fromResponse($response)
    {
        return new Currency($response['code'], $response['symbol']);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'code'   => $this->getCode(),
            'symbol' => $this->getSymbol(),
        ];
    }
}
