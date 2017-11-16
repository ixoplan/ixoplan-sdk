<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlCheck extends Condition
{

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws \Exception
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result)
    {
        $url = $request->getScheme().'://'.$request->getHost().$request->getPath().$request->getQuery();

        return $this->compare($url, $this->parameters['value'], $this->parameters['comparator']);
    }


}