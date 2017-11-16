<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlHostCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlHostCheck extends Condition
{

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws \Exception
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result)
    {

        return $this->compare($request->getHost(), $this->parameters['value'], $this->parameters['comparator']);
    }


}