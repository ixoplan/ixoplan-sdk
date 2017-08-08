<?php

use Ixolit\Dislo\Redirector\Rules\Actions\SetCookie;
use Ixolit\Dislo\Redirector\Base\RedirectorRequest;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

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

        $redirectorResult = new RedirectorResult();
        $redirectorRequest = new RedirectorRequest();

        $redirectToUrl->process($redirectorResult, $redirectorRequest);

        $this->assertCount(1, $redirectorResult->getCookies());
        $this->assertEquals('cookieName', $redirectorResult->getCookies()[0]->getName());

    }

}