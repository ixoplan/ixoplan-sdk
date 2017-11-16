<?php

namespace Ixolit\Dislo\Redirector\Base;

/**
 * Class RedirectorRequest
 * @package Ixolit\Dislo\Redirector\Base
 */
class RedirectorRequest implements RedirectorRequestInterface
{

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var RequestParameter[]
     */
    protected $requestParameters = [];

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var Cookie[]
     */
    protected $cookies = [];

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * country code, e.g.: US, GB, DE, AT
     *
     * @var string
     */
    protected $ipBasedCountryCode;

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return RedirectorRequest
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return RedirectorRequest
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return RedirectorRequest
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     * @return RedirectorRequest
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return RequestParameter[]
     */
    public function getRequestParameters()
    {
        return $this->requestParameters;
    }

    /**
     * @param RequestParameter[] $requestParameters
     * @return RedirectorRequest
     */
    public function setRequestParameters($requestParameters)
    {
        $this->requestParameters = $requestParameters;
        return $this;
    }

    /**
     * @param RequestParameter $requestParameter
     * @return RedirectorRequest
     */
    public function addRequestParameters($requestParameter)
    {
        array_push($this->requestParameters, $requestParameter);
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return RedirectorRequest
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
     * @return RedirectorRequest
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * @param Cookie $cookie
     * @return RedirectorRequest
     */
    public function addCookie($cookie)
    {
        array_push($this->cookies, $cookie);
        return $this;
    }

    /**
     * @return string
     */
    public function getIpBasedCountryCode()
    {
        return $this->ipBasedCountryCode;
    }

    /**
     * @param string $ipBasedCountryCode
     * @return RedirectorRequest
     */
    public function setIpBasedCountryCode($ipBasedCountryCode)
    {
        $this->ipBasedCountryCode = $ipBasedCountryCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return RedirectorRequest
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $headerName
     * @param string $headerValue
     * @return RedirectorRequest
     */
    public function setHeader($headerName, $headerValue)
    {
        $headers = $this->getHeaders();
        if (!is_array($headers)) {
            $headers = [];
        }
        $headers[$headerName] = $headerValue;
        $this->setHeaders($headers);

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getHeader($key) {
        return isset($this->headers[$key]) ? $this->headers[$key] : null;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function setFromUrl($url) {

        $this->scheme = parse_url($url, PHP_URL_SCHEME);
        $this->host = parse_url($url, PHP_URL_HOST);
        $this->path = parse_url($url, PHP_URL_PATH);
        $this->query = parse_url($url, PHP_URL_QUERY);
        return $this;
    }
}