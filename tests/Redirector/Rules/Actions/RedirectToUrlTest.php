<?php

use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Rules\Actions\RedirectToUrl;
use Psr\Http\Message\ResponseInterface;

/**
 * Class RedirectToUrlTest
 * @package Ixolit\Dislo\Redirector
 */
class RedirectToUrlTest extends \PHPUnit_Framework_TestCase
{

    public function testRedirectToUrl() {

        $redirectToUrl = new RedirectToUrl(['statusCode' => 307, 'url' => 'http://test.ixolit.com']);

        $redirectorResult = new RedirectorResult();
        $redirectorRequest = new RedirectorRequest();

        $redirectToUrl->process($redirectorResult, $redirectorRequest);

        $this->assertEquals(true, $redirectorResult->isRedirect());
        $this->assertEquals(307, $redirectorResult->getStatusCode());
        $this->assertEquals('http://test.ixolit.com', $redirectorResult->getUrl());
        $this->assertInstanceOf(ResponseInterface::class, $redirectorResult->getResponse());

    }

}