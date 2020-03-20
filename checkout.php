<?php
require_once('manage/includes/settings.php');
include('includes/header.php');

$consumer = \regodesign\users\Consumers::readConsumerByID($_SESSION['id']);
$retailer = \regodesign\users\Retailers::readRetailerByID($consumer->getRetailerID());
$carts = \regodesign\store\Carts::readCartByConsumer($consumer->getID());
?>

  	<div class="row">
		<div id="search" style="float: left">
			<form action="search.php" method="GET">
			 <input type="text" id="search-text" name="q"><input type="submit" value="SEARCH">
			</form>

            <div class="clear"></div>

            <?php //include('includes/cart.php'); ?>
		</div>

		<div id="checkout">
			<form id="checkoutOrder" method="POST" action="update-to-cart.php">
                <h2>Checkout</h2>
                
                <div id="error" style="color:#DD0000"></div>
                <?php $totalQty = 0; $totalPrice = number_format(0,2);
                if(!empty($carts)){ ?>
                    <p>To finalize the order, click 'Place Order' on the bottom of the cart table</p>
                    <input type="hidden" name="redirect" value="<?=$_SERVER['REQUEST_URI'] ?>" />                
                    <input type="text" name="poNumber" id="poNumber" placeholder="PO #">
                    <?php if ($_SESSION['type'] == 2): ?>
                        <div class="ordered-by">
                            <input type="text" id="order-name" placeholder="Ordered by">
                            <input type="text" id="order-address" placeholder="Address">
                            <input type="text" id="order-city" placeholder="City">
                            <input type="text" id="order-state" placeholder="State">
                            <input type="text" id="order-zip" placeholder="Zip Code">
                            <input type="text" id="order-phone" placeholder="Phone">
                            <input type="text" id="order-email" id="order-email" placeholder="Email">
                        </div>
                    <?php else: ?>
                        <input type="text" id="order-name" placeholder="Ordered by">
                        <input type="hidden" value="." id="order-address" placeholder="Address">
                        <input type="hidden" value="." id="order-city" placeholder="City">
                        <input type="hidden" value="." id="order-state" placeholder="State">
                        <input type="hidden" value="." id="order-zip" placeholder="Zip Code">
                        <input type="hidden" value="." id="order-phone" placeholder="Phone">
                        <input type="hidden" value="." id="order-email" id="order-email" placeholder="Email">
                    <?php endif;
                    
                    foreach($carts as $cart): 
                    $product = \regodesign\store\Products::readProductBySKU($cart->getProductID());
                    
                    if ($_SESSION['type'] == 2) { //Customers of retailers should only see the markup prices
                        $individualPrice = $product->getPrice() * $retailer->getMarkup();
                    } else {
                        $individualPrice = $product->getPrice();
                    }
                    
                    $subTotalPrice = $individualPrice * $cart->getQuantity(); 
                    $totalQty += $cart->getQuantity(); 
                    $totalPrice += $subTotalPrice; ?>

                    <div class="checkoutItem">
                        <div class="column">
                            <a href="product.php?id=<?= $product->getSKU() ?>"><img width="64" src="<?= $product->getImage(); ?>"></a>
                        </div>
                        <div class="column productName">
                            <a href="product.php?id=<?= $product->getSKU() ?>"><p><?= $product->getName() ?><input type="hidden" name="id[]" value="<?= $cart->getID() ?>"></p></a>
                            <p>Special Instructions:<br><textarea name="special[<?= $cart->getID() ?>]" id="special"><?= $cart->getInstructions() ?></textarea></p>
                            <?php if ($cart->getRingSize()): ?>
                                <p>Ring Size: <select id="ring-size" name="ring-size[<?= $cart->getID() ?>]">
                                    <option value="stock">Stock</option>
                                    <?php for ($i = 1; $i <= 18; $i+=0.25): ?>
                                        <option value="<?= $i ?>" <?php if ($i == $cart->getRingSize()) echo 'selected'; ?>><?= $i ?></option>
                                    <?php endfor; ?>
                                </select></p>
                            <?php endif; ?>
                        </div><!--.productName-->
                        
                        <div class="column productQty">
                            <p><input type="text" id="quantity[<?= $cart->getID() ?>]" name="quantity[<?= $cart->getID() ?>]" value="<?= $cart->getQuantity() ?>" /></p>
                            <a class="removeBtn" href="#" data-target="<?=$cart->getID()?>" style="margin-left: -6px;font-size: 12px; color:#555">Remove</a>
                        </div>

                        <div class="column productIndividualPrice">
                            <p>$<?= number_format($individualPrice, 2) ?></p>
                        </div><!--.productIndividualPrice-->

                        <div class="column productSubTotalPrice">
                            <p>$<?= number_format($subTotalPrice, 2) ?></p>
                        </div><!--.productSubTotalPrice-->

                        <div class="clear"></div>
                    </div><!--.orderItem-->
                    <?php endforeach; ?>
                    <p style="color:#333; font-size:12px">Changes from stock ring sizes (Ladies 6.5 and Gents 9.5) or special instructions and 
requests may result in increased costs not reflected in this total. Shipping and
insurance charges not included. Total does not include sales tax.</p>
                <?php if ($_SESSION['type'] == 2): ?>
                    <p>If we do not contact you to confirm this order and arrange payment within 2 business days, please contact us.</p>
                <?php endif; ?>
                    <p>Shipping Instructions:</p>
                    <textarea style="width: 100%;" rows="2" id="shippingInstructions"></textarea>
                    <div id="checkoutTotals">
                        <p class="column update"><input type="submit" value="Update Cart" class="buttons" /></p>
                        <p class="column totalQty">Total QTY: <?= $totalQty ?></p>
                        <p class="column totalPrice">Total: $<?= number_format($totalPrice, 2) ?></p>
                        <p class="column confirm"><a id="process-order" href="process-order.php" class="buttons">Place Order</a></p>

                        <div class="clear"></div>
                    </div><!--#checkoutTotals-->
                <?php } else {
                    echo '<p>There are no products in the cart</p>';
                } ?>
                
                
            </form><!--#checkoutOrder-->
		</div> <!--#checkout-->
  	</div> <!-- row -->
    <script>
        $('.removeBtn').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('target');
            $('input[name="quantity['+id+']"]').val(0);
            $('#checkoutOrder').submit();
        });

        $('.ordered-by input').on('focus', function(e) {
            $(this).parent().animate({height: 175}, 500);
        });
        $('.ordered-by #order-email').on('blur', function(e) {
            $(this).parent().animate({height: 25}, 500);
        });
        $('#process-order').on('click', function(e) {
            e.preventDefault();
            var name = $('#order-name').val();
            var address = $('#order-address').val();
            var city = $('#order-city').val();
            var state = $('#order-state').val();
            var zip = $('#order-zip').val();
            var phone = $('#order-phone').val();
            var email = $('#order-email').val();
            var instructions = $('#shippingInstructions').val();
            var poNumber = $('#poNumber').val();

            if (name !== '' && address !== '' && city !== '' && state !== '' && zip !== '' && phone !== '' && email !== '')
            {
                var $form = $('<form action="process-order.php" method="POST"><input type="hidden" name="name" value="' + name + '"><input type="hidden" name="address" value="' + address + '"><input type="hidden" name="city" value="' + city + '"><input type="hidden" name="state" value="'+ state + '"><input type="hidden" name="zip" value="' + zip + '"><input type="hidden" name="phone" value="' + phone + '"><input type="hidden" name="email" value="' + email + '"><input type="hidden" name="shippingInstructions" value="' + instructions + '"><input type="hidden" name="poNumber" value="' + poNumber + '"></form>');
                $form.appendTo('body').submit();
            } else {
                $('#order-name').focus();
                $('#error').text('Please enter contact information for this order before placing order.');
            }
        });
    </script>
<?php include('includes/footer.php'); ?>