<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Base\RequestParameter;


/**
 * Class UrlQueryCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class RequestParameterCheck extends ComparisonCheck
{
    /**
     * @var string
     */
    protected $comparator;

    /**
     * @var string
     */
    protected $requestParameterName;

    /**
     * @var string
     */
    protected $requestParameterValue;

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            '=',
            '!=',
            'exists'
        ];
    }

    /**
     * @param array $parameters
     * @throws \Exception
     */
    protected function validateParameters($parameters) {

        if (empty($parameters['requestParameterName'])) {
            throw new \Exception(__METHOD__.': Missing parameter "requestParameterName"');
        }
        if (empty($parameters['comparator'])) {
            throw new \Exception(__METHOD__.': Missing parameter "comparator"');
        }
        if (!in_array($parameters['comparator'], $this->getPossibleComparatorOperators())) {
            throw new \Exception(__METHOD__.': Invalid value of parameter "comparator": '.$parameters['comparator']);
        }
        if ($parameters['comparator'] != 'exists' && empty($parameters['requestParameterValue'])) {
            throw new \Exception(__METHOD__.': Missing parameter "requestParameterValue"');
        }
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->validateParameters($parameters);

        $this->comparator = $parameters['comparator'];
        $this->requestParameterName = $parameters['requestParameterName'];
        $this->requestParameterValue = !empty($parameters['requestParameterValue']) ? $parameters['requestParameterValue'] : null;
    }

    /**
     * @param RedirectorResult $result
     * @param RedirectorRequestInterface $request
     * @return bool
     * @throws \Exception
     */
    public function evaluate(RedirectorResult $result, RedirectorRequestInterface $request)
    {

        return $this->check($request->getRequestParameters());
    }

    /**
     * @param RequestParameter[] $requestParameters
     * @return bool
     * @throws \Exception
     */
    public function check($requestParameters) {

        $requestParameters = $this->sanitizeRequestParameters($requestParameters);

        $requestParameterValue = !empty($requestParameters[$this->requestParameterName]) ? $requestParameters[$this->requestParameterName] : '';

        if ($this->comparator === '=') {
            return $requestParameterValue === $this->requestParameterValue;
        }

        if ($this->comparator === '!=') {
            return $requestParameterValue !== $this->requestParameterValue;
        }

        if ($this->comparator === 'exists') {
            return array_key_exists($this->requestParameterName, $requestParameters);
        }

        throw new \Exception(__METHOD__.': Invalid value of parameter "comparator": '.$this->comparator);
    }

    /**
     * @param RequestParameter[] $requestParameters
     * @return []
     */
    protected function sanitizeRequestParameters($requestParameters) {

        $sanitized = [];

        foreach ($requestParameters as $requestParameter) {
            $sanitized[$requestParameter->getName()] = $requestParameter->getValue();
        }

        return $sanitized;
    }

}