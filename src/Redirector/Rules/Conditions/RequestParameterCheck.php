<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RequestParameter;

/**
 * Class RequestParameterCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class RequestParameterCheck extends NameValueCheck {

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            self::KEY_PARAM_COMP => 'comparator',
            self::KEY_PARAM_NAME => 'requestParameterName',
            self::KEY_PARAM_VALUE => 'requestParameterValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @return RequestParameter[]
     */
    protected  function getNameValues(RedirectorRequestInterface $request) {
        return $request->getRequestParameters();
    }
}