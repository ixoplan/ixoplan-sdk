<?php

use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Base\RedirectorState;
use Ixolit\Dislo\Redirector\Rules\Actions\SetCookie;

/**
 * Class SetCookieTest
 * @package Ixolit\Dislo\Redirector
 */
class SetCookieTest extends \PHPUnit_Framework_TestCase
{

    public function testSetCookie() {

        $redirectToUrl = new SetCookie(
            [
                'cookieName' => 'cookieName',
                'cookieValue' => 'cookieValue',
                'maxAge' => '2700',
                'httpOnly' => 'true',
                'requireSSL' => 'true'
            ]);

        $redirectorState = new RedirectorState();
        $redirectorResult = new RedirectorResult();
        $redirectorRequest = new RedirectorRequest();

        $redirectToUrl->process($redirectorState, $redirectorResult, $redirectorRequest);

        $this->assertCount(1, $redirectorResult->getCookies());
        $this->assertEquals('cookieName', $redirectorResult->getCookies()[0]->getName());

    }

}