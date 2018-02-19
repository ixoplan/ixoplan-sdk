<?php

namespace Ixolit\Dislo\Request;

/**
 * Provides a static timestamp value.
 *
 * @package Dislo
 *
 * @deprecated
 */
class StaticTimeProvider implements TimeProvider {
	/**
	 * @var int
	 */
	private $timestamp;

	/**
	 * @param int $timestamp
	 */
	public function __construct($timestamp) {
		$this->timestamp = $timestamp;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getTimestamp() {
		return $this->timestamp;
	}
}