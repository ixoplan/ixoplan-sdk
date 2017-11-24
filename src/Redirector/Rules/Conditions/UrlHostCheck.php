<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;

/**
 * Class UrlHostCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlHostCheck extends Condition
{

    /**
     * @param RedirectorInterface $redirector
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorInterface $redirector, RedirectorRequestInterface $request, RedirectorResultInterface $result)
    {

        return $this->compare($request->getHost(), $this->parameters['value'], $this->parameters['comparator']);
    }


}