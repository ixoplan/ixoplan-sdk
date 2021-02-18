<?php

namespace Ixolit\Dislo\Request;

/**
 * Additionaly allow the client to enable / disable the dev mode to retrieve plans/billings methods, etc. which shall not be generally available
 *
 * @package Dislo
 */
interface RequestClientWithDevModeSupport extends RequestClient {

    /**
     * @param boolean $devMode
     * @return $this
     */
    public function setDevMode($enabled);

}
