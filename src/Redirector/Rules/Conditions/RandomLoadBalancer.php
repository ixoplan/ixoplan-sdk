<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;

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
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorStateInterface $redirectorState, RedirectorRequestInterface $request, RedirectorResultInterface $result) {
        return $this->evaluate();
    }

    public function evaluate() {
        return rand(0, 99) < $this->parameters['value'];
    }
}