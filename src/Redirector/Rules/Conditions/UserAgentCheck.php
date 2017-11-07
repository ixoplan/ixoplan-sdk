<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Base\RequestParameter;


/**
 * Class UserAgentCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UserAgentCheck extends ComparisonCheck
{

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            'regex'
        ];
    }

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     * @throws RedirectorException
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {

        return $this->check($request->getHeader('User-Agent'));
    }

    /**
     * @param string $userAgentData
     * @return bool
     * @throws RedirectorException
     */
    public function check($userAgentData) {

        return (bool) preg_match($this->value, $userAgentData);
    }

}