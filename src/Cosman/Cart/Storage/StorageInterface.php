<?php

namespace Cosman\Cart\Storage;

use Cosman\Cart\Cart;

interface StorageInterface {

	/**
	 * Saves a cart to a persistent storage
	 *
	 * @param Cart $cart        	
	 * @return bool
	 */
	public function saveCart(Cart $cart);

}