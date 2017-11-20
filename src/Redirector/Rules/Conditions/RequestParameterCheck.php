<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;

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
            'comparator' => 'comparator',
            'paramName' => 'requestParameterName',
            'paramValue' => 'requestParameterValue',
        ];
    }

    /**
     * @param RedirectorRequestInterface $request
     * @param RedirectorResult $result
     * @return bool
     */
    public function evaluateFromRequest(RedirectorRequestInterface $request, RedirectorResult $result) {
        return $this->check($this->sanitizeNameValues($request->getRequestParameters()));
    }
}