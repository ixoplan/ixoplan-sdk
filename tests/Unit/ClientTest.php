<?php

namespace Ixolit\Dislo\Unit;

use Ixolit\Dislo\Helper\RequestHelper;
use Ixolit\Dislo\Client;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\Response\MiscGetCurrenciesResponse;
use Ixolit\Dislo\TestCase;
use Ixolit\Dislo\WorkingObjects\Currency;

/**
 * Class ClientTest
 *
 * @package Ixolit\Dislo\Unit
 */
final class ClientTest extends TestCase
{
    use RequestHelper;

    //region Tests

    /**
     * @return void
     */
    public function testMiscGetCurrencies()
    {
        $currencyCode = $this->getFaker()->currencyCode;
        $currencySymbol = '$';
        $response = ['currencies' => [['code' => $currencyCode, 'symbol' => $currencySymbol]]];
        $requestClient = $this->createRequestClient();
        $this->mockRequestClientRequest($requestClient, $response, '/frontend/misc/currencies', []);

        $this->assertEquals(
            new MiscGetCurrenciesResponse([new Currency($currencyCode, $currencySymbol)]),
            $this->getClient($requestClient)->miscGetCurrencies()
        );
    }

    /**
     * @return void
     */
    public function testMiscGetCurrenciesWithUserToken()
    {
        $userToken = $this->getFaker()->word;
        $currencyCode = $this->getFaker()->currencyCode;
        $currencySymbol = '$';
        $response = ['currencies' => [['code' => $currencyCode, 'symbol' => $currencySymbol]]];
        $requestClient = $this->createRequestClient();
        $this->mockRequestClientRequest($requestClient, $response, '/frontend/misc/currencies', ['authToken' => $userToken]);

        $this->assertEquals(
            new MiscGetCurrenciesResponse([new Currency($currencyCode, $currencySymbol)]),
            $this->getClient($requestClient)->miscGetCurrencies($userToken)
        );
    }

    /**
     * @return void
     */
    public function testMiscGetCurrenciesWithUserId()
    {
        $userId = $this->getFaker()->numberBetween();
        $currencyCode = $this->getFaker()->currencyCode;
        $currencySymbol = '$';
        $response = ['currencies' => [['code' => $currencyCode, 'symbol' => $currencySymbol]]];
        $requestClient = $this->createRequestClient();
        $this->mockRequestClientRequest($requestClient, $response, '/frontend/misc/currencies', ['userId' => $userId]);

        $this->assertEquals(
            new MiscGetCurrenciesResponse([new Currency($currencyCode, $currencySymbol)]),
            $this->getClient($requestClient)->miscGetCurrencies($userId)
        );
    }

    /**
     * @return void
     */
    public function testMiscGetCurrenciesWithSubscriptionId()
    {
        $userId = $this->getFaker()->numberBetween(1);
        $subscriptionId = $this->getFaker()->numberBetween(1);
        $currencyCode = $this->getFaker()->currencyCode;
        $currencySymbol = '$';
        $response = ['currencies' => [['code' => $currencyCode, 'symbol' => $currencySymbol]]];
        $requestClient = $this->createRequestClient();
        $this->mockRequestClientRequest(
            $requestClient,
            $response,
            '/frontend/misc/currencies',
            ['userId' => $userId, 'subscriptionId' => $subscriptionId]
        );

        $this->assertEquals(
            new MiscGetCurrenciesResponse([new Currency($currencyCode, $currencySymbol)]),
            $this->getClient($requestClient)->miscGetCurrencies($userId, $subscriptionId)
        );
    }

    //endregion

    private function getClient(RequestClient $requestClient = null, $forceTokenMode = false)
    {
        return new Client($requestClient ?: $this->createRequestClient(), $forceTokenMode);
    }
}
