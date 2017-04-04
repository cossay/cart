<?php
require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

use Cosman\Cart\Config\CartConfig;
use Cosman\Cart\Cart;
use Cosman\Cart\CartItem;

$config = new CartConfig();
$cart = new Cart($config);

$item1 = new CartItem(1, "Dell XPS 15", "1500");
$item2 = new CartItem(2, "LG 32in TV", "2000", 2);
$item3 = new CartItem(3, "Huawei Holly C3");
$item3->setPrice("780");
$item3->setQuantity(5);
$item3->setDiscountRate("0.015");
$item3->setTaxRate("0.012");
$cart->addItem($item1);
$cart->addItem($item2);
$cart->addItem($item3);

//Get items in cart
$cart->getItems();

//Display items in cart
foreach ($cart->getItems() as $curItem) {
	echo $curItem->getKey(), ' ', $curItem->getName(), ' ', $curItem->getPrice(), PHP_EOL;
	//echo $curItem, PHP_EOL;
}

//Convert an item to a JSON
echo $item1, PHP_EOL;
//or
echo json_encode($item1), PHP_EOL;

//Total discount
echo $cart->getTotalDiscount(), PHP_EOL;

//Total tax
echo $cart->getTotalTax(), PHP_EOL;

//Total cost
echo $cart->getTotalCost(), PHP_EOL;

//Grand total
echo $cart->getGrandTotal(), PHP_EOL;

//Convert cart to JSON
echo $cart, PHP_EOL;
//or
echo json_encode($cart);

//Save a cart to a persistence storate
$cart->save();