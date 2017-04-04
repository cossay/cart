<?php

namespace Cosman\Cart;

use Cosman\Cart\Exception\EmptyItemKeyException;
use Cosman\Cart\Exception\CartException;
use Cosman\Cart\Exception\EmptyItemNameException;

class CartItem implements CartItemInterface {

	/**
	 *
	 * @var mixed
	 */
	private $key;

	/**
	 *
	 * @var string
	 */
	private $name;

	/**
	 *
	 * @var double
	 */
	private $price;

	/**
	 *
	 * @var number
	 */
	private $quantity;

	/**
	 *
	 * @var double
	 */
	private $discount;

	/**
	 *
	 * @var double
	 */
	private $tax;

	/**
	 *
	 * @var double
	 */
	private $discount_rate;

	/**
	 *
	 * @var double
	 */
	private $tax_rate;

	/**
	 *
	 * @var double
	 */
	private $total;

	/**
	 *
	 * @var double
	 */
	private $grand_total;

	/**
	 *
	 * @param mixed $key        	
	 * @param string $name        	
	 * @param number $price        	
	 * @param number $quantity        	
	 */
	public function __construct($key, $name, $price = 0, $quantity = 1, $discount = 0, $tax = 0) {

		$this->setKey($key);
		$this->setName($name);
		$this->setPrice($price);
		$this->setQuantity($quantity);
		$this->setDiscountRate($discount);
		$this->setTaxRate($tax);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getKey()
	 */
	public function getKey() {

		return $this->key;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getName()
	 */
	public function getName() {

		return $this->name;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getPrice()
	 */
	public function getPrice() {

		return $this->price;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getQuantity()
	 */
	public function getQuantity() {

		return $this->quantity;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getTotal()
	 */
	public function getTotal($digits = 2) {

		return bcmul($this->quantity, $this->price, $digits);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getGrandTotal()
	 */
	public function getGrandTotal($digits = 2) {

		$tax = $this->getTax($digits);
		$discount = $this->getDiscount($digits);
		
		$total = bcsub($this->getTotal($discount), $discount, $digits);
		
		return bcadd($total, $tax, $digits);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setKey()
	 */
	public function setKey($key) {

		if (empty($key)) {
			throw new EmptyItemKeyException();
		}
		
		$this->key = $key;
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setName()
	 */
	public function setName($name) {

		if (empty($name)) {
			throw new EmptyItemNameException();
		}
		
		$this->name = $name;
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setPrice()
	 */
	public function setPrice($price) {

		$this->price = doubleval($price);
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setQuantity()
	 */
	public function setQuantity($quantity) {

		$this->quantity = abs($quantity);
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getDiscount()
	 */
	public function getDiscount($digits = 2) {

		return bcmul($this->getTotal($digits), $this->discount_rate, $digits);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getTax()
	 */
	public function getTax($digits = 2) {

		return bcmul($this->getTotal($digits), $this->tax_rate, $digits);
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getDiscountRate()
	 */
	public function getDiscountRate() {

		return $this->discount_rate;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::getTaxRate()
	 */
	public function getTaxRate() {

		return $this->tax_rate;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setDiscountRate()
	 */
	public function setDiscountRate($rate) {

		$rate = doubleval($rate);
		
		if (0 > $rate || 1 < $rate) {
			throw new CartException('Discount must be a positive number between 0 and 1.');
		}
		
		$this->discount_rate = $rate;
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::setTaxRate()
	 */
	public function setTaxRate($rate) {

		$rate = doubleval($rate);
		
		if (0 > $rate || 1 < $rate) {
			throw new CartException('Tax must be a positive number between 0 and 1.');
		}
		
		$this->tax_rate = $rate;
		
		return $this;
	
	}

	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Cosman\Cart\CartItemInterface::__toString()
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

		$this->total = $this->getTotal();
		$this->grand_total = $this->getGrandTotal();
		$this->discount = $this->getDiscount();
		$this->tax = $this->getTax();
		return get_object_vars($this);
	
	}

}