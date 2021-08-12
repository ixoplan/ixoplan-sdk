<?php

namespace Ixolit\Dislo\Helper;

use Ixolit\Dislo\Request\RequestClient;
use Mockery as m;
use Mockery\MockInterface;

/**
 * Trait RequestHelper
 *
 * @package Ixolit\Dislo\Helper
 */
trait RequestHelper
{
    /**
     * @return RequestClient|MockInterface
     */
    private function createRequestClient()
    {
        return m::spy(RequestClient::class);
    }

    /**
     * @param RequestClient|MockInterface $requestClient
     * @param array|\Exception            $response
     * @param string                      $uri
     * @param array                       $data
     *
     * @return $this
     */
    private function mockRequestClientRequest(MockInterface $requestClient, $response, $uri, array $data)
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
