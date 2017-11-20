<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

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
            'comparator' => 'comparator',
            'paramName' => 'headerName',
            'paramValue' => 'headerValue',
        ];
    }

    protected function sanitizeName($name) {
        return strtolower($name);
    }

    protected function sanitizeValue($value) {
        // RFC2616: Multiple headers with same name MAY appear for fields defined as a comma-separated list.
        // It MUST be possible to concatenate them without changing the semantics of the message.
        if (is_array($value)) {
            $value = implode(',', $value);
        }
        else {
            $value = strval($value);
        }
        return $value;
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result) {
        return $this->check($this->sanitizeNameValues($request->getHeaders()));
    }
}