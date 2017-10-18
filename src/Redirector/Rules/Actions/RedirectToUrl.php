<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class RedirectToUrl
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
class RedirectToUrl extends Action
{

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $url;

    /**
     * blablabla adfadfdaf
     *
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->statusCode = $parameters['statusCode'] ? (int) $parameters['statusCode'] : 302;
        $this->url = $parameters['url'];

    }

    /**
     * @param RedirectorResult $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {
        $redirectorResult->setRedirect(true)
            ->setStatusCode($this->statusCode)
            ->setUrl($this->url);
    }

}