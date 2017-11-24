<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;

/**
 * Class UrlPathCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlPathCheck extends Condition
{

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorStateInterface $redirectorState, RedirectorRequestInterface $request, RedirectorResultInterface $result)
    {

        return $this->compare($request->getPath(), $this->parameters['value'], $this->parameters['comparator']);
    }


}