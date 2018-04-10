<?php
use Ixolit\Dislo\Response\UserGetBalanceResponse;
use Ixolit\Dislo\Test\AbstractTestCase;
use Ixolit\Dislo\Test\WorkingObjects\PriceMock;

/**
 * Class UserGetBalanceResponseTest
 */
class UserGetBalanceResponseTest extends AbstractTestCase {

    /**
     * @return void
     */
    public function testConstructor() {
        $balance = PriceMock::create();

        $userGetBalanceResponse = new UserGetBalanceResponse($balance);

        $reflectionObject = new \ReflectionObject($userGetBalanceResponse);

        $balanceProperty = $reflectionObject->getProperty('balance');
        $balanceProperty->setAccessible(true);
        $this->comparePrice($balanceProperty->getValue($userGetBalanceResponse), $balance);
    }

    /**
     * @return void
     */
    public function testGetters() {
        $balance = PriceMock::create();

        $userGetBalanceResponse = new UserGetBalanceResponse($balance);

        $this->comparePrice($userGetBalanceResponse->getBalance(), $balance);
    }

    /**
     * @return void
     */
    public function testFromResponse() {
        $balance = PriceMock::create();

        $response = [
            'balance' => $balance->toArray(),
        ];

        $userGetBalanceResponse = UserGetBalanceResponse::fromResponse($response);

        $this->comparePrice($userGetBalanceResponse->getBalance(), $balance);
    }

}