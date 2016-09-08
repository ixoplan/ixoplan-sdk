<?php

namespace Ixolit\Dislo\Request;

/**
 * Interface for clients to call Dislo.
 *
 * @package Dislo
 */
interface RequestClient {
	/**
	 * @param string $uri
	 * @param array $params
	 *
	 * @return string
	 */
	public function request($uri, array $params);
}