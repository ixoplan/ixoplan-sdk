<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlHostCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlHostCheck extends ComparisonCheck
{

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {

        return $this->compare($request->getHost(), $this->value, $this->comparator);
    }


}