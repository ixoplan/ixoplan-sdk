<?php

namespace Ixolit\Dislo\Request;

/**
 * Time providers provide the current UNIX timestamp.
 *
 * @package Dislo
 */
interface TimeProvider {
	/**
	 * @return int
	 */
	public function getTimestamp();
}