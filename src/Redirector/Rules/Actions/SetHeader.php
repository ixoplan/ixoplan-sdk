<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Exceptions\RedirectorException;
use Ixolit\Dislo\Redirector\Base\Header;
use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Redirector;

/**
 * Class SetHeader
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
class SetHeader extends Action {

    /**
     * @var string
     */
    protected $headerName;

    /**
     * @var string
     */
    protected $headerValue;

    /**
     * @param array $parameters
     * @throws RedirectorException
     */
    protected function validateParameters($parameters) {
        if (empty($parameters['headerName'])) {
            throw new RedirectorException(__METHOD__.': Missing parameter "headerName"');
        }
        if (empty($parameters['headerValue'])) {
            throw new RedirectorException(__METHOD__.': Missing parameter "headerValue"');
        }
    }

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters) {
        $this->validateParameters($parameters);

        $this->headerName = $parameters['headerName'];
        $this->headerValue = $parameters['headerValue'];

        return $this;
    }

    /**
     * @param RedirectorInterface $redirector
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorInterface $redirector, RedirectorResultInterface $redirectorResult, RedirectorRequestInterface $redirectorRequest) {

        $redirectorResult->setHeader(
            (new Header())
                ->setName($this->headerName)
                ->setValue($this->headerValue)
        );
    }
}