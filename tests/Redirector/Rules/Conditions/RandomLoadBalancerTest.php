<?php
namespace test;

use Ixolit\Dislo\Redirector\Rules\Conditions\RandomLoadBalancer;

/**
 * Class CountryCheckTest
 * @package Ixolit\Dislo\Redirector
 */
class RandomLoadBalancerTest extends \PHPUnit_Framework_TestCase
{

    public function testRandomLoadBalancer1() {

        // test data
        $testParameters = [
            'comparator' => 'lower_than',
            'value' => '100'
        ];
        $expectedResult = false;

        // build objects
        $randomLoadBalancer = new RandomLoadBalancer($testParameters);

        // test
        $result = $randomLoadBalancer->evaluate();
        $this->assertEquals($expectedResult, $result);
    }

    public function testRandomLoadBalancer2() {

        // test data
        $testParameters = [
            'comparator' => 'lower_than',
            'value' => '0'
        ];
        $expectedResult = true;

        // build objects
        $randomLoadBalancer = new RandomLoadBalancer($testParameters);

        // test
        $result = $randomLoadBalancer->evaluate();
        $this->assertEquals($expectedResult, $result);
    }

}