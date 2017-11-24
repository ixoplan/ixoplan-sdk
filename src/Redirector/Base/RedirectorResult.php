<?php

namespace Ixolit\Dislo\Redirector\Base;

use Psr\Http\Message\ResponseInterface;

/**
 * Class RedirectorResult
 * @package Ixolit\Dislo\Redirector\Base
 */
class RedirectorResult implements RedirectorResultInterface {

    // TODO: used for tests only?

    /**
     * @var bool
     */
    protected $redirect;

    /**
     * @var int
     */
    protected $statusCode = 302;

    /**
     * @var string
     */
    protected $url = null;

    /**
     * Cookies to set / Set-Cookie
     *
     * @var Cookie[]
     */
    protected $cookies = [];

    /**
     * @var Header[]
     */
    protected $headers = [];

    /**
     * @var SessionVariable[]
     */
    protected $sessionVariables = [];

    /**
     * @return bool
     */
    public function isRedirect() {
        return $this->redirect;
    }

    /**
     * @return int
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @return null
     */
    public function getUrl() {
        return $this->url;
    }

    public function sendRedirect($statusCode, $location) {
        $this->redirect = true;
        $this->statusCode = $statusCode;
        $this->url = $location;
    }

    /**
     * @return Cookie[]
     */
    public function getCookies() {
        return $this->cookies;
    }

    /**
     * @param Cookie $cookie
     * @return RedirectorResult
     */
    public function setCookie($cookie) {
        array_push($this->cookies, $cookie);
        return $this;
    }

    /**
     * @return Header[]
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param Header $header
     * @return RedirectorResult
     */
    public function setHeader($header) {
        array_push($this->headers, $header);
        return $this;
    }

    /**
     * @return SessionVariable[]
     */
    public function getSessionVariables() {
        return array_values($this->sessionVariables);
    }

    /**
     * @param SessionVariable $variable
     * @return RedirectorResult
     */
    public function setSessionVariable($variable) {
        array_push($this->sessionVariables, $variable);
        return $this;
    }

    /**
     * Put result's properties to PSR-7 response
     *
     * @param ResponseInterface $response
     *
     * @return ResponseInterface
     */
    public function toResponse(ResponseInterface $response) {

        if ($this->isRedirect()) {
            $response = $response
                ->withStatus($this->getStatusCode())
                ->withHeader('Location', $this->getUrl());
        }

        foreach ($this->getCookies() as $cookie) {
            $response = $response->withAddedHeader('Set-Cookie', [$cookie->getSetCookieValueString()]);
        }

        return $response;
    }

}