<?php require_once('manage/includes/settings.php');

$quantities = $_POST['quantity'];
$specials = $_POST['special'];
$sizes = $_POST['ring-size'];
$ids = $_POST['id'];

foreach($ids as $id){
	$cartItem = new regodesign\store\Carts;
    $cartItem->setID($id);
	$cartItem->setConsumerID($_SESSION['id']);
	$cartItem->setProductID($product);
	$cartItem->setQuantity($quantities[$id]);

    if (isset($specials[$id])) {
        $cartItem->setInstructions($specials[$id]);
    }

    if (isset($sizes[$id])) $cartItem->setRingSize($sizes[$id]);

	if($cartItem->getQuantity() > 0){
		$cartItem->updateCart();
	} else {
		$cartItem->delete();
	}
}

header('Location:'.$_POST['redirect']);