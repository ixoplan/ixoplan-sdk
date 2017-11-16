<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Exceptions\RedirectorException;
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
     * @param RedirectorResult $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     * @return array
     */
    protected function getParameterKeys() {
        return [
            'comparator',
            'cookieName',
            'cookieValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     * @throws \Exception
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result)
    {

        return $this->check($request->getCookies());
    }

    /**
     * @param Cookie[] $cookies
     * @return bool
     * @throws RedirectorException
     */
    public function check($cookies) {

        $cookieParameters = [];

        foreach ($cookies as $cookie) {
            $cookieParameters[$cookie->getName()] = $cookie;
        } ;

        $comparator = $this->parameters['comparator'];
        $cookieName = $this->parameters['cookieName'];
        $cookieValuePattern = !empty($this->parameters['cookieValue']) ? $this->parameters['cookieValue'] : '';


        if ($comparator === self::COMPARATOR_EXISTS) {
            return array_key_exists($cookieName, $cookieParameters);
        }
        if ($comparator === self::COMPARATOR_NOT_EXISTS) {
            return ! array_key_exists($cookieName, $cookieParameters);
        }

        /** @var Cookie $cookie */
        $cookie = !empty($cookieParameters[$cookieName]) ? $cookieParameters[$cookieName] : null;

        return $this->compare($cookie->getValue(), $cookieValuePattern, $comparator);

    }

    /**
     * @return Cookie[]
     */
    protected function getCookiesFromHeaders() {
        return [];
    }
}