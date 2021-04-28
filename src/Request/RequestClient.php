<?php

namespace Ixolit\Dislo\Request;

/**
 * Interface for clients to call Ixoplan.
 *
 * @package Dislo
 */
interface RequestClient {
	/**
	 * @param string $uri
	 * @param array $params
	 *
	 * @return array
	 */
	public function request($uri, array $params);
}