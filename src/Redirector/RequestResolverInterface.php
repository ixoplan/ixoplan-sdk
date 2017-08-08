<?php

namespace Ixolit\Dislo\Redirector;

use Ixolit\Dislo\Redirector\Base\RedirectorRequestInterface;

interface RequestResolverInterface
{

    /**
     * @return RedirectorRequestInterface
     */
    public function getRedirectorRequest();

}