<?php

use Ixolit\Dislo\Redirector\Rules\Conditions\UrlCheck;

/**
 * Class ComparisonCheckTest
 * @package Ixolit\Dislo\Redirector
 */
class ComparisonCheckTest extends \PHPUnit_Framework_TestCase
{

    public function testUrlCheck1() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'starts_with';
        $value = 'http://www.test';
        $expectedResult = true;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUrlCheck2() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'starts_with';
        $value = 'https://www.test';
        $expectedResult = false;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUrlCheck3() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'includes';
        $value = 'st.ixolit.';
        $expectedResult = true;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUrlCheck4() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'includes';
        $value = 'https://www.test';
        $expectedResult = false;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUrlCheck5() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'regex';
        $value = '|test.IXOLIT.com|i';
        $expectedResult = true;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

    public function testUrlCheck6() {

        $url = 'http://www.test.ixolit.com';
        $comparator = 'regex';
        $value = '|test.IXOLIT.com|';
        $expectedResult = false;

        $urlCheck = new UrlCheck();
        $result = $urlCheck->compare($url, $value, $comparator);
        $this->assertEquals($expectedResult, $result);
    }

}