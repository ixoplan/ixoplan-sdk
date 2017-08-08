<?php

use Ixolit\Dislo\Redirector\Base\Cookie;
use Ixolit\Dislo\Redirector\Rules\Conditions\CookieCheck;

/**
 * Class CookieCheckTest
 * @package Ixolit\Dislo\Redirector
 */
class CookieCheckTest extends \PHPUnit_Framework_TestCase
{

    public function testCookieCheck1() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = 'exists';
        $expectedResult = true;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue(null)];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck2() {

        // test data
        $cookieName = 'cookieName3';
        $comparator = 'exists';
        $expectedResult = false;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue(null)];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck3() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = '=';
        $cookieValue = 'cookieValue1';
        $expectedResult = true;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck4() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = '=';
        $cookieValue = 'not_matching';
        $expectedResult = false;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck5() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = '!=';
        $cookieValue = 'cookieValue1';
        $expectedResult = false;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck6() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = '!=';
        $cookieValue = 'not_matching';
        $expectedResult = true;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck7() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = 'regex';
        $cookieValue = '/kievalue1/i';
        $expectedResult = true;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }

    public function testCookieCheck8() {

        // test data
        $cookieName = 'cookieName1';
        $comparator = 'regex';
        $cookieValue = '/kievalue1/';
        $expectedResult = false;

        // build objects
        $cookies = [(new Cookie())->setName('cookieName1')->setValue('cookieValue1')];
        $cookieCheck = new CookieCheck(['cookieName' => $cookieName, 'comparator' => $comparator, 'cookieValue' => $cookieValue]);

        // test
        $result = $cookieCheck->check($cookies);
        $this->assertEquals($expectedResult, $result);
    }



}