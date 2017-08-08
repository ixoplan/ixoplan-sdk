<?php

use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Rules\Actions\NoRedirection;

/**
 * Class NoRedirectionTest
 * @package Ixolit\Dislo\Redirector
 */
class NoRedirectionTest extends \PHPUnit_Framework_TestCase
{

    public function testNoRedirection() {

        $redirectToUrl = new NoRedirection();

        $redirectorResult = new RedirectorResult();
        $redirectorRequest = new RedirectorRequest();

        $redirectToUrl->process($redirectorResult, $redirectorRequest);

        $this->assertEquals(false, $redirectorResult->isRedirect());
        $this->assertEquals(null, $redirectorResult->getResponse());

    }



}