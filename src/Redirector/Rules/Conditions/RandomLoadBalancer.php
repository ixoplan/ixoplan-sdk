<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class RandomLoadBalancer
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class RandomLoadBalancer extends Condition
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
            'lower_than'
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

        $this->comparator = $comparator;
        $this->value = $parameters['value'];

        return $this;
    }

    /**
     * @return bool
     */
    public function evaluate(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {

        return rand(0, 100) < $this->value;
    }


}