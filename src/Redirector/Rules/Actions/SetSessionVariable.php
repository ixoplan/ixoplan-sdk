<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\SessionVariable;

/**
 * Class SetSessionVariable
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
class SetSessionVariable extends Action {

    /**
     * @var string
     */
    protected $variableName;

    /**
     * @var string
     */
    protected $variableValue;

    /**
     * @param array $parameters
     * @throws RedirectorException
     */
    protected function validateParameters($parameters) {
        if (empty($parameters['variableName'])) {
            throw new RedirectorException(__METHOD__.': Missing parameter "variableName"');
        }
        if (!array_key_exists('variableValue', $parameters)) {
            throw new RedirectorException(__METHOD__.': Missing parameter "variableValue"');
        }
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters) {
        $this->validateParameters($parameters);

        $this->variableName = $parameters['variableName'];
        $this->variableValue = $parameters['variableValue'];

        return $this;
    }

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorStateInterface $redirectorState, RedirectorResultInterface $redirectorResult, RedirectorRequestInterface $redirectorRequest) {

        $redirectorResult->setSessionVariable(
            (new SessionVariable())
                ->setName($this->variableName)
                ->setValue($this->variableValue)
        );
    }
}