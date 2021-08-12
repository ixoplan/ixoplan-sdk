<?php

namespace Ixolit\Dislo\WorkingObjects;

use Ixolit\Dislo\WorkingObjectsCustom\CurrencyCustom;

/**
 * Class Currency
 *
 * @package Ixolit\Dislo\WorkingObjects
 */
final class Currency extends AbstractWorkingObject
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
     * @return CurrencyCustom|null
     */
    public function getCustom()
    {
        return ($this->getCustomObject() instanceof CurrencyCustom)
            ? $this->getCustomObject()
            : null;
    }

    /**
     * @return CurrencyCustom|WorkingObjectCustomInterface
     */
    public function getCustomObject()
    {
        return parent::getCustomObject();
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
