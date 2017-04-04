<?php

namespace Cosman\Cart\Config;

use Cosman\Cart\Storage\StorageInterface;

class CartConfig {

	/**
	 *
	 * @var StorageInterface $storage
	 */
	private $storage;

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
	 * @param number $tax        	
	 * @param number $discount        	
	 * @param StorageInterface $storage        	
	 */
	public function __construct($tax = 0, $discount = 0, StorageInterface $storage = null) {

		$this->setTax($tax);
		$this->setDiscount($discount);
		$this->setStorage($storage);
	
	}

	/**
	 * Returns tax setting for the configurtion
	 *
	 * @return double
	 */
	public function getTax() {

		return $this->tax;
	
	}

	/**
	 * Sets tax
	 *
	 * @param double $tax        	
	 * @return CartConfig
	 */
	public function setTax($tax) {

		$this->tax = $tax;
		
		return $this;
	
	}

	/**
	 * Returns discount settings for this configuration
	 *
	 * @return double
	 */
	public function getDiscount() {

		return $this->discount;
	
	}

	/**
	 * Sets discount for this configuration
	 *
	 * @param double $discount        	
	 * @return CartConfig
	 */
	public function setDiscount($discount) {

		$this->discount = doubleval($discount);
		
		return $this;
	
	}

	/**
	 * Returns persistent storage layer
	 *
	 * @return StorageInterface | null
	 */
	public function getStorage() {

		return $this->storage;
	
	}

	/**
	 * Sets persistent storage layer for this configuration
	 *
	 * @param StorageInterface $storage
	 *        	| null
	 * @return CartConfig
	 */
	public function setStorage(StorageInterface $storage = null) {

		$this->storage = $storage;
		
		return $this;
	
	}

}