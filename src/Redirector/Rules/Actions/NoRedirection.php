<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResult;


/**
 * Class NoRedirection
 * @package Ixolit\Dislo\Redirector\Rules\Actions
 */
class NoRedirection extends Action
{

    /**
     * @param array $parameters
     * @return $this
     */
    public function setParameters($parameters)
    {
        // no parameters
        return $this;
    }

    /**
     * @param RedirectorResult $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorResult $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {
        $redirectorResult->setRedirect(false);
    }

}