<?php

use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Redirector;
use Ixolit\Dislo\Redirector\Rules\Actions\NoRedirection;

/**
 * Class NoRedirectionTest
 * @package Ixolit\Dislo\Redirector
 */
class NoRedirectionTest extends \PHPUnit_Framework_TestCase
{

    public function testNoRedirection() {

        $redirectToUrl = new NoRedirection();

        $redirector = new Redirector([]);
        $redirectorResult = new RedirectorResult();
        $redirectorRequest = new RedirectorRequest();

        $redirectToUrl->process($redirector, $redirectorResult, $redirectorRequest);

        $this->assertEquals(null, $redirectorResult->isRedirect());
        $this->assertEquals(true, $redirector->isBreak());

    }

}