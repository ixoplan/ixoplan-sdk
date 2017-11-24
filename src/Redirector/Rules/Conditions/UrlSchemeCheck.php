<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;


/**
 * Class UrlSchemeCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class UrlSchemeCheck extends Condition
{

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            self::COMPARATOR_EQUALS,
            self::COMPARATOR_NOT_EQUALS
        ];
    }

    /**
     * @return string[]
     */
    protected static function getPossibleValues() {
        return [
            'https',
            'http'
        ];
    }

    /**
     * @param array $parameters
     * @throws \Exception
     */
    protected function validateParameters($parameters) {
        parent::validateParameters($parameters);

        if (!in_array($parameters['value'], $this->getPossibleValues())) {
            throw new \Exception(__METHOD__.': Invalid value of parameter "comparator": '.$parameters['comparator']);
        }
    }

    /**
     * @param array $parameters
     * @return $this
     * @throws RedirectorException
     */
    public function setParameters($parameters)
    {
        //validation
        $comparator = $parameters['comparator'] ?: null;
        if (!in_array($comparator, self::getPossibleComparatorOperators())) {
            throw new RedirectorException(__METHOD__.': Invalid Operator: '.$comparator);
        }
        if (!in_array($parameters['value'], self::getPossibleValues())) {
            throw new RedirectorException(__METHOD__.': Invalid Value: '.$this->value);
        }

        $this->comparator = $comparator;
        $this->value = $parameters['value'];

        return $this;
    }

    /**
     * @param RedirectorInterface $redirector
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorInterface $redirector, RedirectorRequestInterface $request, RedirectorResultInterface $result)
    {

        return $this->compare($request->getScheme(), $this->parameters['value'], $this->parameters['comparator']);
    }


}