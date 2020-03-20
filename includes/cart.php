<form id="shoppingCart" action="update-to-cart.php" method="POST">
    <h2 style="margin-bottom:0">Cart</h2>
    <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI'] ?>" />
    <?php //Display the cart on the sidebar
        $carts = \regodesign\store\Carts::readCartByConsumer($_SESSION['id']);
        foreach ($carts as $cart): 
            $cart_item = \regodesign\store\Products::readProductBySKU($cart->getProductID()); ?>
            <div class="cartItem" style="display: flex; align-items: center; justify-content: space-between">
                <input type="hidden" name="id[]" value="<?= $cart->getID() ?>">
                <input type="hidden" name="special[<?php echo $cart->getID(); ?>]" value="<?php echo $cart->getInstructions(); ?>">
                <?php if ($cart->getRingSize()): ?>
                    <input type="hidden" name="ring-size[<?php echo $cart->getID(); ?>]" value="<?php echo $cart->getRingSize(); ?>">
                <?php endif; ?>
                <p class="name"><a style="display: flex; align-items: center;" href="product.php?id=<?=$cart_item->getSKU(); ?>"><img width="72" src="<?= $cart_item->getImage() ?>"><?=$cart_item->getSKU(); ?></a></p>
                <p class="qty"><input type="text" name="quantity[<?= $cart->getID() ?>]" value="<?=$cart->getQuantity(); ?>" /></p>
                <div class="clear"></div>
            </div><!--.cartItem-->
        <?php endforeach; ?>
    <input type="submit" value="Update Cart" class="cartButton" />
    <a href="checkout.php" class="cartButton">Go to Cart</a>
</form>