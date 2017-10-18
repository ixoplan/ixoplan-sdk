<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Class UrlPathCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlPathCheck extends ComparisonCheck
{

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {

        return $this->compare($request->getPath(), $this->value, $this->comparator);
    }


}