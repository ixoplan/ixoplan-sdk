<?php

namespace Ixolit\Dislo\WorkingObjects;

interface WorkingObject {
	/**
	 * @param array $response
	 *
	 * @return self
	 */
	public static function fromResponse(array $response);

	public function toArray();
}