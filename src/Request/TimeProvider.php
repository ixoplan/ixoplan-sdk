<?php

namespace Ixolit\Dislo\Request;

/**
 * Time providers provide the current UNIX timestamp.
 *
 * @package Ixolit\Dislo\Request
 */
interface TimeProvider {
	/**
	 * @return int
	 */
	public function getTimestamp();
}