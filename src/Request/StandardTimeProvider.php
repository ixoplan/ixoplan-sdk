<?php

namespace Ixolit\Dislo\Request;

/**
 * Provides the timestamp using the built-in PHP time() function.
 *
 * @package Dislo
 */
class StandardTimeProvider implements TimeProvider {
	/**
	 * {@inheritdoc}
	 */
	public function getTimestamp() {
		return \time();
	}
}