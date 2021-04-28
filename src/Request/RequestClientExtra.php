<?php

namespace Ixolit\Dislo\Request;

use Psr\Http\Message\StreamInterface;

/**
 * Interface for clients to call Ixoplan.
 *
 * @package Ixolit\Dislo\Request
 */
interface RequestClientExtra {
	/**
	 * @param string $uri
	 * @param array $params
	 * @param mixed $stream
	 *
	 * @return StreamInterface
	 */
	public function requestStream($uri, array $params, $stream);
}