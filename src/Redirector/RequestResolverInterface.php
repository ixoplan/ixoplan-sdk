<?php

namespace Ixolit\Dislo\Redirector;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;

/**
 * Interface RequestResolverInterface
 * @package Ixolit\Dislo\Redirector
 */
interface RequestResolverInterface
{

    /**
     * @return RedirectorRequestInterface
     */
    public function getRedirectorRequest();

}