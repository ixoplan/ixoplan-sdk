<?php

namespace Ixolit\Dislo\Response;

use Ixolit\Dislo\WorkingObjects\Currency;

/**
 * Class MiscGetCurrenciesResponse
 *
 * @package Ixolit\Dislo\Response
 */
final class MiscGetCurrenciesResponse
{
    /**
     * @var Currency[]
     */
    private $currencies;

    /**
     * MiscGetCurrenciesResponse constructor.
     *
     * @param Currency[] $currencies
     */
    public function __construct(array $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * @return Currency[]
     */
    public function getCurrencies()
    {
        return $this->currencies;
    }

    public static function fromResponse(array $response)
    {
        return new MiscGetCurrenciesResponse(
            \array_map(
                function (array $currency) {
                   return Currency::fromResponse($currency);
                },
                $response['currencies']
            )
        );
    }
}
