<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Redirector;


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
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        $this->statusCode = $parameters['statusCode'] ? (int) $parameters['statusCode'] : 302;
        $this->url = $parameters['url'];

        return $this;
    }

    /**
     * @param RedirectorInterface $redirector
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorInterface $redirector, RedirectorResultInterface $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {
        $redirectorResult->sendRedirect($this->statusCode, $this->url);
        $redirector->doBreak();
    }

}