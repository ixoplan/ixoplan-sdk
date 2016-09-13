<?php

namespace Ixolit\Dislo\HTTP;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * Client adapter for HTTP requests. (It is sad that PSR-7 doesn't provide this.)
 *
 * This interface is the specification for ixolit/dislo-sdk-http version 1.0.0. Don't change it.
 *
 * @package Dislo
 */
interface HTTPClientAdapter {
	/**
	 * @return RequestInterface
	 */
	public function createRequest();

	/**
	 * @return UriInterface
	 */
	public function createUri();

	/**
	 * @param string $string
	 *
	 * @return StreamInterface
	 */
	public function createStringStream($string);

	/**
	 * @param RequestInterface $request
	 *
	 * @return ResponseInterface
	 */
	public function send(RequestInterface $request);
}