<?php

namespace Ixolit\Dislo\Redirector\Rules\Conditions;

use Ixolit\Dislo\Redirector\Base\Header;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;
use Ixolit\Dislo\Redirector\Base\RequestParameter;


/**
 * Class HeaderCheck
 * @package Ixolit\Dislo\Redirector\Rules\Conditions
 */
class HeaderCheck extends Condition
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
     * @return array
     */
    protected function getParameterKeys() {
        return [
            'comparator',
            'headerName',
            'headerValue',
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

        return $this->check($request->getHeaders());
    }

    /**
     * @param Header[] $headers
     * @return bool
     * @throws \Exception
     */
    public function check($headers) {

        $headers = $this->sanitizeHeaders($headers);

        $comparator = $this->parameters['comparator'];
        $headerName = $this->parameters['headerName'];
        $headerValuePattern = !empty($this->parameters['headerValue']) ? $this->parameters['headerValue'] : '';

        if ($comparator === self::COMPARATOR_EXISTS) {
            return array_key_exists($headerName, $headers);
        }
        if ($comparator === self::COMPARATOR_NOT_EXISTS) {
            return ! array_key_exists($headerName, $headers);
        }

        $headerValue = !empty($headers[$headerName]) ? $headers[$headerName] : '';
        if (is_array($headerValue)) {
            $headerValue = implode(', ', $headerValue);
        }

        return $this->compare($headerValue, $headerValuePattern, $comparator);
    }

    /**
     * @param Header[] $headers
     * @return []
     */
    protected function sanitizeHeaders($headers) {

        $sanitized = [];

        foreach ($headers as $header) {
            $sanitized[$header->getName()] = $header->getValue();
        }

        return $sanitized;
    }

}