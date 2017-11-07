<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class CountryCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class CountryCheck extends Condition
{

    /**
     * @var string
     */
    protected $comparator;

    /**
     * @var string
     */
    protected $country;

    /**
     * @return string[]
     */
    protected static function getPossibleComparatorOperators() {
        return [
            '=',
            '!='
        ];
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

        $this->comparator = $comparator;
        $this->country = $parameters['country'];

        return $this;
    }

    /**
     * @param RedirectorResult $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     * @return bool
     */
    public function evaluate(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {

        return $this->check($redirectorRequest->getIpBasedCountryCode());

    }

    /**
     * @param string $countryCode
     * @return bool
     * @throws RedirectorException
     */
    public function check($countryCode) {

        if ($this->comparator === '=') {
            return $this->country === $countryCode;
        }

        if ($this->comparator === '!=') {
            return $this->country !== $countryCode;
        }

        throw new RedirectorException(__METHOD__.': Invalid Operator: '.$this->comparator);
    }

}