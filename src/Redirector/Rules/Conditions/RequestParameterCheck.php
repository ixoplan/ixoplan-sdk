<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Base\RequestParameter;


/**
 * Class RequestParameterCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class RequestParameterCheck extends Condition
{

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return array_merge(
            [
                self::COMPARATOR_EXISTS,
                self::COMPARATOR_NOT_EXISTS
            ],
            parent::getPossibleComparatorOperators()
        );
    }

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            'comparator',
            'requestParameterName',
            'requestParameterValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws RedirectorException
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result)
    {

        return $this->check($request->getRequestParameters());
    }

    /**
     * @param RequestParameter[] $requestParameters
     * @return bool
     * @throws RedirectorException
     */
    public function check($requestParameters) {

        $requestParameters = $this->sanitizeRequestParameters($requestParameters);

        $comparator = $this->parameters['comparator'];
        $requestParameterName = $this->parameters['requestParameterName'];
        $requestParameterValuePattern = !empty($this->parameters['requestParameterValue']) ? $this->parameters['requestParameterValue'] : '';

        if ($comparator === self::COMPARATOR_EXISTS) {
            return array_key_exists($requestParameterName, $requestParameters);
        }
        if ($comparator === self::COMPARATOR_NOT_EXISTS) {
            return ! array_key_exists($requestParameterName, $requestParameters);
        }

        $requestParameterValue = !empty($requestParameters[$requestParameterName]) ? $requestParameters[$requestParameterName] : '';

        return $this->compare($requestParameterValue, $requestParameterValuePattern, $comparator);
    }

    /**
     * @param RequestParameter[] $requestParameters
     * @return string[]
     */
    protected function sanitizeRequestParameters($requestParameters) {

        $sanitized = [];

        foreach ($requestParameters as $requestParameter) {
            $sanitized[$requestParameter->getName()] = $requestParameter->getValue();
        }

        return $sanitized;
    }

}