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
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            'lower_than'
        ];
    }

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            'comparator',
            'value',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws \Exception
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result) {
        return $this->evaluate();
    }

    public function evaluate() {
        return ((int) $this->parameters['value']) < rand(0, 99);
    }
}