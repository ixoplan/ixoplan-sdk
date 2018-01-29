<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\NameValue;
use Ixolit\Dislo\Redirector\Base\RedirectorStateInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;

/**
 * Class KeyValueCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
abstract class NameValueCheck extends Condition {

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return array_merge(
            [
                Condition::COMPARATOR_EXISTS,
                Condition::COMPARATOR_NOT_EXISTS
            ],
            parent::getPossibleComparatorOperators()
        );
    }

    /**
     * @param array $parameterKeys
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getParameterByKey($parameterKeys, $key, $default = null) {
        return isset($parameterKeys[$key]) ? $this->parameters[$parameterKeys[$key]] : $default;
    }

    /**
     * @param RedirectorRequestInterface $request
     * @return NameValue[]
     */
    protected abstract function getNameValues(RedirectorRequestInterface $request);

    /**
     * Prepare a name for being used as array key, e.g. make it case insensitive
     *
     * @param string $name
     * @return mixed
     */
    protected function sanitizeName($name) {
        return $name;
    }

    /**
     * Prepare a value to be compared by comparators expecting strings
     *
     * @param mixed $value
     * @return string
     */
    protected function sanitizeValue($value) {

        // RFC2616: Multiple headers with same name MAY appear for fields defined as a comma-separated list, It MUST be
        // possible to concatenate them without changing the semantics of the message. Multiple cookies and query
        // parameters with same name may appear too, treat them all the same way and override if needed ...
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        else {
            $value = strval($value);
        }
        return $value;
    }

    /**
     * @param NameValue[] $nameValues
     * @return string[]
     */
    protected function sanitizeNameValues($nameValues) {

        $sanitized = [];

        foreach ($nameValues as $nameValue) {
            // TODO: check for existing key, convert to array?
            $sanitized[$this->sanitizeName($nameValue->getName())] = $this->sanitizeValue($nameValue->getValue());
        }

        return $sanitized;
    }

    /**
     * @param RedirectorStateInterface $redirectorState
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorStateInterface $redirectorState, RedirectorRequestInterface $request, RedirectorResultInterface $result) {
        return $this->check($this->getNameValues($request));
    }

    /**
     * @param NameValue[] $nameValues
     * @return bool
     */
    public function check($nameValues) {

        $parameterKeys = $this->getParameterKeys();
        $comparator = $this->getParameterByKey($parameterKeys, self::KEY_PARAM_COMP);
        $paramName = $this->sanitizeName($this->getParameterByKey($parameterKeys, self::KEY_PARAM_NAME));
        $paramValue = $this->getParameterByKey($parameterKeys, self::KEY_PARAM_VALUE, '');
        $values = $this->sanitizeNameValues($nameValues);

        if ($comparator === self::COMPARATOR_EXISTS) {
            return array_key_exists($paramName, $values);
        }
        if ($comparator === self::COMPARATOR_NOT_EXISTS) {
            return !array_key_exists($paramName, $values);
        }

        $value = isset($values[$paramName]) ? $values[$paramName] : null;

        return $this->compare($value, $paramValue, $comparator);
    }
}