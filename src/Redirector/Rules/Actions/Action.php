<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Rules\RuleNode;

/**
 * Class Action
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
abstract class Action extends RuleNode
{

    /**
     * Action constructor.
     * @param $parameters
     */
    public function __construct($parameters = null) {
        if (!empty($parameters)) {
            $this->setParameters($parameters);
        }
    }

    /**
     * @param array $parameters
     * @return $this
     */
    abstract public function setParameters($parameters);

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    abstract public function process(
        RedirectorStateInterface $redirectorState,
        RedirectorResultInterface $redirectorResult,
        RedirectorRequestInterface $redirectorRequest
    );

}