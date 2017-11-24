<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;

/**
 * Class UrlCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlCheck extends Condition
{

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorStateInterface $redirectorState, RedirectorRequestInterface $request, RedirectorResultInterface $result)
    {
        $url = $request->getScheme().'://'.$request->getHost().$request->getPath().$request->getQuery();

        return $this->compare($url, $this->parameters['value'], $this->parameters['comparator']);
    }


}