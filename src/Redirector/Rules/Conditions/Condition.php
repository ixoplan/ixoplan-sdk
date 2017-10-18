<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

/**
 * Interface ConditionInterface
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
abstract class Condition
{
    /**
     * Condition constructor.
     * @param null $parameters
     */
    public function __construct($parameters = null) {

        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
    }

    /**
     * @param array $parameters
     */
    abstract public function setParameters($parameters);

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     */
    abstract public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request);

}