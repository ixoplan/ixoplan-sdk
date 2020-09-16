<?php

namespace Ixolit\Dislo\Unit;

use Ixolit\Dislo\AbstractClient;
use Ixolit\Dislo\Exceptions\InvalidRequestParameterException;
use Ixolit\Dislo\Helper\ReflectionHelper;
use Ixolit\Dislo\Request\RequestClient;
use Ixolit\Dislo\TestCase;
use Mockery as m;
use Mockery\MockInterface;

/**
 * Class AbstractClientTest
 *
 * @package Ixolit\Dislo\Unit
 */
final class AbstractClientTest extends TestCase
{
    use ReflectionHelper;

    //region Tests

    /**
     * @return void
     */
    public function testRequestWithInvalidRequestParametersException()
    {
        $uri = $this->getFaker()->url;
        $data = [$this->getFaker()->word => $this->getFaker()->word];
        $response = [
            'success' => false,
            'errors' => [
                [
                    'code'       => 400,
                    'message'    => $this->getFaker()->text,
                    'parameters' => [$this->getFaker()->word],
                ],
            ]
        ];
        $requestHandler = $this->createRequestHandler();
        $this->mockRequestHandlerRequest($requestHandler, $response, $uri, $data);
        $abstractClient = $this->getAbstractClient($requestHandler);

        try {
            $this->runProtectedMethod($abstractClient, 'request', [$uri, $data]);

            $this->assertTrue(false);
        } catch (InvalidRequestParameterException $e) {
            $this->assertEquals($response['errors'][0]['parameters'], $e->getParameters());

            $this->assertTrue(true);

            return;
        }

        $this->assertTrue(false);
    }

    //endregion

    /**
     * @param RequestClient|null $requestClient
     *
     * @return AbstractClient|MockInterface
     */
    private function getAbstractClient(RequestClient $requestClient = null)
    {
        return m::mock(AbstractClient::class, [$requestClient ?: $this->createRequestHandler()])
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
    }

    /**
     * @return RequestClient|MockInterface
     */
    private function createRequestHandler()
    {
        return m::spy(RequestClient::class);
    }

    /**
     * @param MockInterface    $requestClient
     * @param array|\Exception $response
     * @param string           $uri
     * @param array            $data
     *
     * @return $this
     */
    private function mockRequestHandlerRequest(MockInterface $requestClient, $response, $uri, $data)
    {
        $expectation = $requestClient
            ->shouldReceive('request')
            ->with($uri, $data);

        if ($response instanceof \Exception) {
            $expectation->andThrow($response);

            return $this;
        }

        $expectation->andReturn($response);

        return $this;
    }
}
