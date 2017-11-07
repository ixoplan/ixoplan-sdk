<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class UrlSchemeCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlSchemeCheck extends Condition
{
    /**
     * @var string
     */
    protected $comparator;

    /**
     * @var string
     */
    protected $value;

    /**
     * @return string[]
     */
    protected static function getPossibleComparatorOperators() {
        return [
            '='
        ];
    }

    /**
     * @return string[]
     */
    protected static function getPossibleValues() {
        return [
            'https',
            'http'
        ];
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        //validation
        $comparator = $parameters['comparator'] ?: null;
        if (!in_array($comparator, self::getPossibleComparatorOperators())) {
            throw new RedirectorException(__METHOD__.': Invalid Operator: '.$comparator);
        }
        if (!in_array($parameters['value'], self::getPossibleValues())) {
            throw new RedirectorException(__METHOD__.': Invalid Value: '.$this->value);
        }

        $this->comparator = $comparator;
        $this->value = $parameters['value'];
    }

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {

        return $request->getScheme() === $this->value;
    }


}