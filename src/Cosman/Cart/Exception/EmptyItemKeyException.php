<?php 
namespace Cosman\Cart\Exception;

class EmptyItemKeyException extends \Exception {

	public function __construct() {
		parent::__construct('A cart item must have a non empty key.');
	}
}