<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlPathCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlPathCheck extends Condition
{

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws \Exception
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result)
    {

        return $this->compare($request->getPath(), $this->parameters['value'], $this->parameters['comparator']);
    }


}