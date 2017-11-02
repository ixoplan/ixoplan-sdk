<?php

namespace Ixolit\Dislo\Redirector\Base;

use Psr\Http\Message\ResponseInterface;

/**
 * Class RedirectorResult
 * @package Ixolit\Dislo\Redirector\Base
 */
class RedirectorResult
{

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
     * @var string
     */
    protected $method = 'GET';

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return $this->redirect;
    }

    /**
     * @param bool $redirect
     * @return RedirectorResult
     */
    public function setRedirect($redirect)
    {
        $this->redirect = $redirect;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return RedirectorResult
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * @return null
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param null $url
     * @return RedirectorResult
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return Cookie[]
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param Cookie[] $cookies
     * @return RedirectorResult
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * @param Cookie $cookie
     * @return RedirectorResult
     */
    public function addCookie($cookie)
    {
        array_push($this->cookies, $cookie);
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