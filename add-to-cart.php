<?php require_once('manage/includes/settings.php');

use regodesign\store\Carts;

$cart = new Carts;
$cart->setConsumerID($_POST['consumerID']);
$cart->setProductID($_POST['productID']);
$cart->setQuantity($_POST['quantity']);
$cart->setInstructions($_POST['special']);
$cart->setRingSize($_POST['ring-size']);

//Practically a glorified save() method
// if (Carts::readCartExist($cart->getConsumerID(), $cart->getProductID())) {
// 	$cart->updateCart();
// } else {
	$cart->createCart();
// }

header('Location: '.ROOT_URL.'product.php?id='.$_POST['productID']);