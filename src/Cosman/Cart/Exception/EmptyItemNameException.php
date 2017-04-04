<?php

namespace Cosman\Cart\Exception;

class EmptyItemNameException extends \Exception {

	public function __construct() {

		parent::__construct('A cart item must have a name.');
	
	}

}