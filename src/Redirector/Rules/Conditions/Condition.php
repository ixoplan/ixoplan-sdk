<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;

/**
 * Class ComparisonCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
abstract class Condition {

    const KEY_PARAM_COMP = 'comparator';
    const KEY_PARAM_NAME = 'paramName';
    const KEY_PARAM_VALUE = 'paramValue';

    const COMPARATOR_STARTS_WITH = 'starts_with';
    const COMPARATOR_NOT_STARTS_WITH = 'not_starts_with';
    const COMPARATOR_ENDS_WITH = 'ends_with';
    const COMPARATOR_NOT_ENDS_WITH = 'not_ends_with';
    const COMPARATOR_CONTAINS = 'contains';
    const COMPARATOR_NOT_CONTAINS = 'not_contains';
    const COMPARATOR_EQUALS = 'equals';
    const COMPARATOR_NOT_EQUALS = 'not_equals';
    const COMPARATOR_REGEX = 'regex';
    const COMPARATOR_NOT_REGEX = 'not_regex';
    const COMPARATOR_EXISTS = 'exists';
    const COMPARATOR_NOT_EXISTS = 'not_exists';

    /**
     * @var array
     */
    protected $parameters = [];

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
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            self::COMPARATOR_STARTS_WITH,
            self::COMPARATOR_NOT_STARTS_WITH,
            self::COMPARATOR_ENDS_WITH,
            self::COMPARATOR_NOT_ENDS_WITH,
            self::COMPARATOR_CONTAINS,
            self::COMPARATOR_NOT_CONTAINS,
            self::COMPARATOR_EQUALS,
            self::COMPARATOR_NOT_EQUALS,
            self::COMPARATOR_REGEX,
            self::COMPARATOR_NOT_REGEX,
        ];
    }

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            self::KEY_PARAM_COMP => 'comparator',
            self::KEY_PARAM_VALUE => 'value'
        ];
    }

    /**
     * @param array $parameters
     * @throws \Exception
     */
    protected function validateParameters($parameters) {
        $parameterKeys = $this->getParameterKeys();
        foreach ($parameterKeys as $parameterKey) {
            if (!array_key_exists($parameterKey, $parameters)) {
                throw new \Exception(__METHOD__.': Missing parameter "'.$parameterKey.'"');
            }
        }
        if (isset($parameterKeys['comparator'])) {
            if (!in_array($parameters['comparator'], $this->getPossibleComparatorOperators())) {
                throw new \Exception(__METHOD__.': Invalid value of parameter "comparator": '.$parameters['comparator']);
            }
        }
    }

    /**
     * @param array $parameters
     * @return $this
     * @throws \Exception
     */
    public function setParameters($parameters) {
        $this->validateParameters($parameters);
        $this->parameters = array_intersect_key($parameters, array_flip($this->getParameterKeys()));
        return $this;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param string $comparator
     * @return bool
     * @throws \Exception
     */
    public function compare($haystack, $needle, $comparator) {

        if ($comparator === 'starts_with') {
            return (bool) preg_match('|^'.$needle.'|i', $haystack);
        }
        if ($comparator === 'not_starts_with') {
            return ! preg_match('|^'.$needle.'|i', $haystack);
        }
        if ($comparator === 'ends_with') {
            return (bool) preg_match('|'.$needle.'$|i', $haystack);
        }
        if ($comparator === 'not_ends_with') {
            return ! preg_match('|'.$needle.'$|i', $haystack);
        }
        if ($comparator === 'contains') {
            return (bool) preg_match('|'.$needle.'|i', $haystack);
        }
        if ($comparator === 'not_contains') {
            return ! preg_match('|'.$needle.'|i', $haystack);
        }
        if ($comparator === 'equals') {
            return $haystack == $needle;
        }
        if ($comparator === 'not_equals') {
            return $haystack != $needle;
        }
        if ($comparator === 'regex') {
            return (bool) preg_match($needle, $haystack);
        }
        if ($comparator === 'not_regex') {
            return ! preg_match($needle, $haystack);
        }

        throw new \Exception(__METHOD__.': Invalid Comparator: '.$comparator);
    }

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    abstract public function evaluateFromRequest(RedirectorStateInterface $redirectorState, RedirectorRequestInterface $request, RedirectorResultInterface $result);

}