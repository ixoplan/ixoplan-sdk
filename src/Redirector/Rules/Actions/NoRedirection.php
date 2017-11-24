<?php

namespace Ixolit\Dislo\Redirector\Rules\Actions;

use Ixolit\Dislo\Redirector\Base\RedirectorInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;
use Ixolit\Dislo\Redirector\Base\RedirectorResultInterface;
use Ixolit\Dislo\Redirector\Redirector;


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
     * @param RedirectorInterface $redirector
     * @param RedirectorResultInterface $redirectorResult
     * @param RedirectorRequestInterface $redirectorRequest
     */
    public function process(RedirectorInterface $redirector, RedirectorResultInterface $redirectorResult, RedirectorRequestInterface $redirectorRequest)
    {
//        $redirectorResult->setRedirect(false);
        $redirector->doBreak();
    }

}