<?php

namespace Ixolit\Dislo\Exceptions;

use Exception;

class DisloException extends \Exception {
	public function __construct($message = '', $code = 0, Exception $previous = null) {
		parent::__construct($message, $code, $previous);
	}
}