<?php

namespace Ixolit\Dislo\Redirector\Base;

interface RedirectorResultInterface {

    /**
     * @param Cookie $cookie
     * @return self
     */
    public function setCookie($cookie);

    /**
     * @param Header $header
     * @return self
     */
    public function setHeader($header);

    /**
     * @param SessionVariable $variable
     * @return self
     */
    public function setSessionVariable($variable);

    /**
     * @param int $statusCode
     * @param string $location
     * @return self
     */
    public function sendRedirect($statusCode, $location);
}