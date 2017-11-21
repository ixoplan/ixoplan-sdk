<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\SessionVariable;

/**
 * Class SessionVariableCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class SessionVariableCheck extends NameValueCheck {

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            self::KEY_PARAM_COMP => 'comparator',
            self::KEY_PARAM_NAME => 'variableName',
            self::KEY_PARAM_VALUE => 'variableValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @return SessionVariable[]
     */
    protected  function getNameValues(RedirectorRequestInterface $request) {
        return $request->getSessionVariables();
    }
}