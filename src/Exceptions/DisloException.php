<?php

namespace Ixolit\Dislo\Exceptions;

use Exception;

class DisloException extends \Exception {
	public function __construct($message, $code, Exception $previous) {
		parent::__construct($message, $code, $previous);
		var_dump($message);
		exit;
	}

}