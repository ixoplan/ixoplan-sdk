<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\NameValue;

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
     * @param string $name
     * @return mixed
     */
    protected function sanitizeName($name) {
        return $name;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function sanitizeValue($value) {
        return strval($value);
    }

    /**
     * @param NameValue[] $nameValues
     * @return string[]
     */
    protected function sanitizeNameValues($nameValues) {

        $sanitized = [];

        foreach ($nameValues as $nameValue) {
            $sanitized[$this->sanitizeName($nameValue->getName())] = $this->sanitizeValue($nameValue->getValue());
        }

        return $sanitized;
    }

    /**
     * @param array $keyValues
     * @return bool
     */
    public function check($keyValues) {

        $parameterKeys = $this->getParameterKeys();
        $comparator = $this->getParameterByKey($parameterKeys, 'comparator');
        $paramName = $this->sanitizeName($this->getParameterByKey($parameterKeys, 'paramName'));
        $paramValue = $this->getParameterByKey($parameterKeys, 'paramValue', '');

        if ($comparator === self::COMPARATOR_EXISTS) {
            return array_key_exists($paramName, $keyValues);
        }
        if ($comparator === self::COMPARATOR_NOT_EXISTS) {
            return !array_key_exists($paramName, $keyValues);
        }

        $value = isset($keyValues[$paramName]) ? $keyValues[$paramName] : null;

        return $this->compare($value, $paramValue, $comparator);
    }
}