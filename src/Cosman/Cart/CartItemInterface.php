<?php

namespace Cosman\Cart;

interface CartItemInterface extends \JsonSerializable {

	/**
	 * Returns item key
	 *
	 * @return mixed
	 */
	public function getKey();

	/**
	 * Returns item name
	 *
	 * @return string
	 */
	public function getName();

	/**
	 * Returns item price
	 *
	 * @return double
	 */
	public function getPrice();

	/**
	 * Returns item quantity
	 *
	 * @return number
	 */
	public function getQuantity();

	/**
	 * Returns discount on item
	 *
	 * @param int $digits        	
	 * @return double
	 */
	public function getDiscount($digits = 2);

	/**
	 * Returns tax on product
	 *
	 * @param number $digits        	
	 */
	public function getTax($digits = 2);

	/**
	 * Returns percentage discount on item
	 *
	 * @return double
	 */
	public function getDiscountRate();

	/**
	 * Returns percentage tax on item
	 *
	 * @return double
	 */
	public function getTaxRate();

	/**
	 * Sets percentage discount on item
	 *
	 * @param double $rate        	
	 * @return CartItemInterface
	 */
	public function setDiscountRate($rate);

	/**
	 * Set percentage tax on item
	 *
	 * @param double $rate        	
	 * @return CartItemInterface
	 */
	public function setTaxRate($rate);

	/**
	 * Calculates item cost total
	 *
	 * @param int $digits        	
	 * @return double
	 */
	public function getTotal($digits = 2);

	/**
	 * Calculates grand total
	 *
	 * @param int $digits        	
	 * @return double
	 */
	public function getGrandTotal($digits = 2);

	/**
	 * Sets item key
	 *
	 * @param mixed $key        	
	 * @return CartItemInterface
	 */
	public function setKey($key);

	/**
	 * Sets item name
	 *
	 * @param string $name        	
	 * @return CartItemInterface
	 */
	public function setName($name);

	/**
	 * Sets item price
	 *
	 * @param double $price        	
	 * @return CartItemInterface
	 */
	public function setPrice($price);

	/**
	 * Sets item quantity
	 *
	 * @param number $quantity        	
	 * @return CartItemInterface
	 */
	public function setQuantity($quantity);

	/**
	 * Returns a string representation of an item
	 * 
	 * @return string
	 */
	public function __toString();

}