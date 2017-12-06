<?php

use Ixolit\Dislo\Redirector\Base\RequestParameter;
use Ixolit\Dislo\Redirector\Rules\Conditions\RequestParameterCheck;

/**
 * Class RequestParameterCheckTest
 * @package Ixolit\Dislo\Redirector\Base
 */
class RequestParameterCheckTest extends \PHPUnit_Framework_TestCase
{

    public function testQueryParameterCheck1() {

        // set test data
        $parameters = [
            'comparator' => 'equals',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => 'requestParameterValue1'
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = 'requestParameterValue1';

        $expectedResult = true;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck2() {

        // set test data
        $parameters = [
            'comparator' => 'equals',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => 'requestParameterValue1'
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = 'no_match';

        $expectedResult = false;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck3() {

        // set test data
        $parameters = [
            'comparator' => 'not_equals',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => 'requestParameterValue1'
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = 'requestParameterValue1';

        $expectedResult = false;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck4() {

        // set test data
        $parameters = [
            'comparator' => 'not_equals',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => 'requestParameterValue1'
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = 'no_match';

        $expectedResult = true;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck5() {

        // set test data
        $parameters = [
            'comparator' => 'exists',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => ''
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = null;

        $expectedResult = true;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck6() {

        // set test data
        $parameters = [
            'comparator' => 'exists',
            'requestParameterName' => 'requestParameterName3',
            'requestParameterValue' => ''
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = null;

        $expectedResult = false;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck7() {

        // set test data
        $parameters = [
            'comparator' => 'not_exists',
            'requestParameterName' => 'requestParameterName1',
            'requestParameterValue' => ''
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = null;

        $expectedResult = false;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }

    public function testQueryParameterCheck8() {

        // set test data
        $parameters = [
            'comparator' => 'not_exists',
            'requestParameterName' => 'requestParameterName3',
            'requestParameterValue' => ''
        ];
        $requestParameterName = 'requestParameterName1';
        $requestParameterValue = null;

        $expectedResult = true;

        // build objects
        $requestParameter = new RequestParameter();
        $requestParameter->setName($requestParameterName)
            ->setValue($requestParameterValue);
        $requestParameters = [$requestParameter];
        $requestParameterCheck = new RequestParameterCheck($parameters);
        $requestParameterCheck->setParameters($parameters);

        // test
        $result = $requestParameterCheck->check($requestParameters);

        $this->assertEquals($expectedResult, $result);

    }


}