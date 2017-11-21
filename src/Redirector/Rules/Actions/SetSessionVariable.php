<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
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
        if (empty($parameters['variableValue'])) {
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
     * @param RedirectorResult $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest) {

        $redirectorResult->addSessionVariable(
            (new SessionVariable())
                ->setName($this->variableName)
                ->setValue($this->variableValue)
        );
    }
}