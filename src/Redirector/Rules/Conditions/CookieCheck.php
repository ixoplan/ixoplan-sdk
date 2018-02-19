<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\Cookie;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;

/**
 * Class CookieCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class CookieCheck extends NameValueCheck {

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            self::KEY_PARAM_COMP => 'comparator',
            self::KEY_PARAM_NAME => 'cookieName',
            self::KEY_PARAM_VALUE => 'cookieValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @return Cookie[]
     */
    protected  function getNameValues(RedirectorRequestInterface $request) {
        return $request->getCookies();
    }
}