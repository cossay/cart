<?php

namespace Cosman\Cart;

use Cosman\Cart\Config\CartConfig;

class Cart implements \JsonSerializable {

	/**
	 *
	 * @var CartConfig
	 */
	private $config;

	/**
	 *
	 * @var CartItemInterface[]
	 */
	private $items;

	public function __construct(CartConfig $config) {

		$this->items = array();
		
		$this->config = $config;
	
	}

	/**
	 * Returns all items in the cart
	 *
	 * @return CartItemInterface[]
	 */
	public function getItems() {

		return array_values($this->items);
	
	}

	/**
	 * Fetches an item by key
	 *
	 * @param mixed $key        	
	 * @return null|CartItemInterface
	 */
	public function getItemByKey($key) {

		return array_key_exists($key, $this->items) ? $this->items[$key] : null;
	
	}

	/**
	 * Checks if a given item is already in the cart
	 *
	 * @param CartItemInterface $item        	
	 * @return boolean
	 */
	public function hasItem(CartItemInterface $item) {

		return array_key_exists($item->getKey(), $this->items);
	
	}

	/**
	 * Adds an item to the cart
	 *
	 * @param CartItemInterface $item        	
	 * @return Cart
	 */
	public function addItem(CartItemInterface $item) {

		$key = $item->getKey();
		
		if (!$this->hasItem($item)) {
			$this->items[$key] = $item;
		} else {
			$quantity = $this->items[$key]->getQuantity();
			$this->items[$key]->setQuantity($quantity + $item->getQuantity());
		}
		
		return $this;
	
	}

	/**
	 * Removes a number of a given item from the cart
	 *
	 * @param CartItemInterface $item        	
	 * @param
	 *        	int | null $quantity
	 * @return Cart
	 */
	public function removeItem(CartItemInterface $item, $quantity = null) {

		if ($this->hasItem($item)) {
			
			$key = $item->getKey();
			$qty = $this->items[$key]->getQuantity();
			
			if (null === $quantity || $quantity >= $qty) {
				unset($this->items[$key]);
			} else {
				$this->items[$key]->setQuantity($qty - $quantity);
			}
		}
		
		return $this;
	
	}

	/**
	 * Removes a number of a given item by key
	 *
	 * @param mixed $key        	
	 * @param
	 *        	int | null $quantity
	 * @return Cart
	 */
	public function removeItemByKey($key, $quantity = null) {

		$item = $this->getItemByKey($key);
		
		if (null !== $item) {
			$this->removeItem($item, $quantity);
		}
		
		return $this;
	
	}

	/**
	 * Checks if a cart is empty
	 *
	 * @return bool
	 */
	public function isEmpty() {

		return empty($this->items);
	
	}

	/**
	 * Empties a cart
	 *
	 * @return Cart
	 */
	public function empty() {

		return $this->items = [];
		
		return $this;
	
	}

	/**
	 * Returns total cost of items in cart
	 *
	 * @param int $digits        	
	 * @return double
	 */
	public function getTotalCost($digits = 2) {

		$total = 0;
		
		foreach ( $this->items as $item ) {
			$total = bcadd($total, $item->getTotal(), $digits);
		}
		
		return $total;
	
	}

	/**
	 * Returns grand total for a cart
	 *
	 * @param number $digits        	
	 * @return double
	 */
	public function getGrandTotal($digits = 2) {

		$total = 0;
		
		foreach ( $this->items as $item ) {
			$total = bcadd($total, $item->getGrandTotal($digits), $digits);
		}
		
		return $total;
	
	}

	/**
	 * Returns total discount for a cart
	 *
	 * @param number $digits        	
	 * @return double
	 */
	public function getTotalDiscount($digits = 2) {

		$total = 0;
		
		foreach ( $this->items as $item ) {
			$total = bcadd($total, $item->getDiscount($digits), $digits);
		}
		
		return $total;
	
	}

	/**
	 * Returns total tax for a cart
	 *
	 * @param number $digits        	
	 * @return double
	 */
	public function getTotalTax($digits = 2) {

		$total = 0;
		
		foreach ( $this->items as $item ) {
			$total = bcadd($total, $item->getTax($digits), $digits);
		}
		
		return $total;
	
	}

	/**
	 * Returns cart configuration
	 *
	 * @return CartConfig
	 */
	public function getConfig() {

		return $this->config;
	
	}

	/**
	 * Sets configuration a cart
	 *
	 * @param CartConfig $config        	
	 * @return Cart
	 */
	public function setConfig(CartConfig $config) {

		$this->config = $config;
		
		return $this;
	
	}

	/**
	 * Save cart to a persistent storage
	 *
	 * @return boolean
	 */
	public function save() {

		$storage = $this->config->getStorage();
		
		return null === $storage ? false : $storage->saveCart($this);
	
	}

	/**
	 * Returns a string representation of a cart
	 *
	 * @return string
	 */
	public function __toString() {

		return json_encode($this);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see JsonSerializable::jsonSerialize()
	 */
	public function jsonSerialize() {

		return array(
			'items' => $this->getItems(),
			'total' => $this->getTotalCost(),
			'grand_total' => $this->getGrandTotal(),
			'total_tax' => $this->getTotalTax(),
			'total_discount' => $this->getTotalDiscount()
		);
	
	}

}
