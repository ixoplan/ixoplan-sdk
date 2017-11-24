<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;


/**
 * Class CountryCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class CountryCheck extends Condition
{

    /**
     * @return string[]
     */
    protected function getPossibleComparatorOperators() {
        return [
            Condition::COMPARATOR_EQUALS,
            Condition::COMPARATOR_NOT_EQUALS
        ];
    }

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            'comparator',
            'country'
        ];
    }

    /**
     * @param RedirectorInterface $redirector
     * @param RedirectorRequestInterface $request
     * @param RedirectorResultInterface $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorInterface $redirector, RedirectorRequestInterface $request, RedirectorResultInterface $result)
    {
        return $this->check($request->getIpBasedCountryCode());
    }

    /**
     * @param string $countryCode
     * @return bool
     * @throws RedirectorException
     */
    public function check($countryCode) {


        return $this->compare($this->parameters['country'], $countryCode, $this->parameters['comparator']);

    }

}