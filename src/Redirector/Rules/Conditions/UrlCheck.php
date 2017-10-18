<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlCheck extends ComparisonCheck
{

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {
        $url = $request->getScheme().'://'.$request->getHost().$request->getPath().$request->getQuery();

        return $this->compare($url, $this->value, $this->comparator);
    }


}