<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\Cookie;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class CookieCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class CookieCheck extends Condition
{

    /**
     * @var string
     */
    protected $cookieName;

    /**
     * @var string
     */
    protected $cookieValue;

    /**
     * @var string
     */
    protected $comparator;

    /**
     * @return string[]
     */
    protected static function getPossibleComparatorOperators() {
        return [
            'exists',
            '=',
            '!=',
            'regex'
        ];
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        //validation
        $comparator = $parameters['comparator'] ?: null;
        if (!in_array($comparator, self::getPossibleComparatorOperators())) {
            throw new \Exception(__METHOD__.': Invalid Operator: '.$comparator);
        }

        $this->comparator = $comparator;
        $this->cookieName = $parameters['cookieName'];
        $this->cookieValue = !empty($parameters['cookieValue']) ? $parameters['cookieValue'] : null;
    }

    /**
     * @return bool
     */
    public function evaluate(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {

        return $this->check($redirectorRequest->getCookies());
    }

    /**
     * @param Cookie[] $cookies
     * return bool
     */
    public function check($cookies) {

        $cookieParameters = [];

        foreach ($cookies as $cookie) {
            $cookieParameters[$cookie->getName()] = $cookie;
        } ;


        if ($this->comparator === 'exists') {
            return array_key_exists($this->cookieName, $cookieParameters);
        }

        $cookie = !empty($cookieParameters[$this->cookieName]) ? $cookieParameters[$this->cookieName] : null;

        if ($this->comparator === '=') {
            return $this->cookieValue === $cookie->getValue();
        }

        if ($this->comparator === '!=') {
            return $this->cookieValue !== $cookie->getValue();
        }

        if ($this->comparator === 'regex') {
            return (bool) preg_match($this->cookieValue, $cookie->getValue());
        }

        throw new \Exception(__METHOD__.': Invalid Operator: '.$this->comparator);
    }

    /**
     * @return Cookie[]
     */
    protected function getCookiesFromHeaders() {
        return [];
    }
}