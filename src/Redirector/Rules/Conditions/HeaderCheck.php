<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\Header;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;

/**
 * Class HeaderCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class HeaderCheck extends NameValueCheck {

    /**
     * @return array
     */
    protected function getParameterKeys() {
        return [
            self::KEY_PARAM_COMP => 'comparator',
            self::KEY_PARAM_NAME => 'headerName',
            self::KEY_PARAM_VALUE => 'headerValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @return Header[]
     */
    public function getNameValues(RedirectorRequestInterface $request) {
        return $request->getHeaders();
    }

    protected function sanitizeName($name) {
        return strtolower($name);
    }
}