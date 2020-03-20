<?php require('manage/includes/settings.php');

$consumer = \regodesign\users\Consumers::readConsumerByID($_SESSION['id']);
$retailer = \regodesign\users\Retailers::readRetailerByID($consumer->getRetailerID());
$carts = \regodesign\store\Carts::readCartByConsumer($consumer->getID());

//First Phase: Create order

//Get total quantity
$totalQty = 0; //Initialize total quantity
foreach ($carts as $cart) {
    $totalQty += $cart->getQuantity();
}

$name = filter_input(INPUT_POST, 'name');
$address = filter_input(INPUT_POST, 'address');
$city = filter_input(INPUT_POST, 'city');
$state = filter_input(INPUT_POST, 'state');
$zip = filter_input(INPUT_POST, 'zip');
$phone = filter_input(INPUT_POST, 'phone');
$email = filter_input(INPUT_POST, 'email');
$shippingInstructions = filter_input(INPUT_POST, 'shippingInstructions');
$poNumber = filter_input(INPUT_POST, 'poNumber');

$order = new regodesign\store\Orders;
$order->setDate(date('Y-m-d H:i:s'));
$order->setQuantity($totalQty);
$order->setShipped(0); //Order was just made, set to 0
$order->setStatus(1); //1 = Process (refer to statuses table)
$order->setCustomerID($consumer->getID());
$order->setTrackingNo('');
$order->setName($name?:'');
$order->setAddress($address?:'');
$order->setCity($city?:'');
$order->setState($state?:'');
$order->setZip($zip?:'');
$order->setPhone($phone?:'');
$order->setEmail($email?:'');
$order->setInstructions($shippingInstructions?:'');
$order->setPONumber($poNumber?:'');

if ($orderID = $order->save()) { //Get the new order id

    //Second Phase: Transfer cart to ProductOrders
    $valid = true;
    foreach ($carts as $cart) {
        $productOrder = new regodesign\store\OrderProducts;
        $productOrder->setOrderID($orderID);
        $productOrder->setProductID($cart->getProductID());
        $productOrder->setQuantity($cart->getQuantity());
        $productOrder->setInstructions($cart->getInstructions());
        $productOrder->setRingSize($cart->getRingSize());
        $productOrder->setShipped(0);
        if (!$productOrder->createProductOrder()) {
            $valid = false;
            break; //Product unable to be entered
        }
    }

    if ($valid) { //Make sure the loop is fully completed

        //Phase 3: Email Order
        if (processEmail($consumer, $retailer, $order, $_SESSION['type'])) {

            //Phase 4: Clean cart
            if (\regodesign\store\Carts::deleteCartByConsumer($consumer->getID())) {
                //Successful Process
                $_SESSION['confirm'] = 'Your order was processed successfully';
            } else {
                $_SESSION['confirm'] = 'Unable to clean the cart, but order was successfully processed. Please contact support.';
            }

        } else {
            $_SESSION['confirm'] = 'Unable to email your processed order, please call support and we will help you finish your process.';
        }
    } else {
        $_SESSION['confirm'] = 'Unable to complete the process of your order, please call support.';
    }
} else {
    $_SESSION['confirm'] = 'Unable to complete the process of your order, please call support.';
}

header('Location: confirm.php');

function processEmail($consumer, $retailer, $order, $type)
{
    $retailerStore = $retailer->getSelfConsumer();
    ob_start(); ?>
    <p>Thank you for your order.  Please contact us if we have not contacted you within 48 hours to confirm this order and arrange your method of payment.</p>
    <h1>Order Detail</h1>

    <table>
    <?php if ($order->getPONumber()): ?>
    <tr>
        <td><h2>PO #<?= $order->getPONumber() ?></h2></td>
    </tr>
    <?php endif; ?>

    <tr>
        <td style="vertical-align: top;"><h2 style="float:left; margin: 0; padding: 0; margin-right: 20px;">Ordered By</h2></td>
        <td style="vertical-align: top;">
            <table style="float:left; margin-bottom: 20px;">
            <tr>
            <td><?= $order->getName() ?></td>
            </tr>
            <?php if ($order->getAddress() !== '.'): ?>
            <tr>
            <td><?= $order->getAddress() ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($order->getCity() !== '.'): ?>
            <tr>
            <td>
                <?= $order->getCity() ?>, 
                <?= $order->getState() ?> 
                <?= $order->getZip() ?>
            </td>
            </tr>
            <?php endif; ?>
            <?php if ($order->getPhone() !== '.'): ?>
            <tr>
            <td><?= $order->getPhone() ?></td>
            </tr>
            <?php endif; ?>
            </table>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: top;"><h2 style="float:left; margin: 0; padding: 0; margin-right: 20px;">Dealer</h2></td>
        <td style="vertical-align: top;">
            <table style="float:left;">
            <tr>
            <td><?= $retailerStore->getFullName() ?></td>
            </tr>
            <tr>
            <td><?= $retailerStore->getAddressStreet() ?></td>
            </tr>
            <tr>
            <td>
            <?= $retailerStore->getAddressCity() ?>, 
            <?= $retailerStore->getAddressState() ?> 
            <?= $retailerStore->getAddressZip() ?>
            </td>
            </tr>
            <tr>
            <td><?= $retailerStore->getPhone() ?></td>
            </tr>
            <tr>
                <td><?= $retailerStore->getEmail() ?></td>
            </tr>
            </table>
        </td>
    </tr>

<?php if (!empty($order->getInstructions())): ?>
    <tr>
        <td><h2 style="float:left; margin: 0; padding: 0; margin-right: 20px;">Shipping Instructions</h2></td>
        <td><?= $order->getInstructions() ?></td>
    </tr>
<?php endif; ?>
</table>
    

    <div>
    <h2>Order</h2>
    <table style="border: 1px solid black; width: 800px; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Sub-Total</th>
            </tr>
        </thead>

        <tbody>
            <?php $productOrders = \regodesign\store\OrderProducts::readProductsByOrder($order->getID());
            $totalQty = 0;
            $totalPrice = number_format(0, 2);
            foreach ($productOrders as $productOrder) {
                $product = \regodesign\store\Products::readProductBySKU($productOrder->getProductID());
                if ($consumer->getType() == 2) { //Consumers should see the markup
                    $individualPrice = $product->getPrice() * $retailer->getMarkup();
                } else {
                    $individualPrice = $product->getPrice();
                }
                
                $subTotalPrice = $individualPrice * $productOrder->getQuantity();
                $totalQty += $productOrder->getQuantity(); 
                $totalPrice += $subTotalPrice; ?>

                <tr style="border-bottom: 1px solid #555">
                    <td>
                        <img width="64" src="<?= $product->getImage(); ?>"> <?= $product->getName() ?><br>
                        <?php if (!empty($productOrder->getRingSize())): ?>
                            <p>Ring Size: <?= $productOrder->getRingSize() ?></p>
                        <?php endif; ?>
                        <p>Special Instructions: <?= $productOrder->getInstructions() ?></p>
                    </td>
                    <td><?= $productOrder->getQuantity() ?></td>
                    <td>$<?= number_format($individualPrice, 2) ?></td>
                    <td>$<?= number_format($subTotalPrice, 2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    </div>

    <br/>
    
    <p>Total QTY: <?=$totalQty; ?></p>
    <p>Total Price: $<?=number_format($totalPrice, 2); ?></p>
    <?php $body = ob_get_clean();

    $main_headers = "MIME-Version: 1.0" . "\r\n";
    $main_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    if ($type == 2) {
        $to = $retailer->getEmail();
        $subject = 'Website Order - ('. $consumer->getRetailerID() .')';
        $headers = $main_headers . 'Bcc: sales@regoonline.com';
        mail($order->getEmail(), $subject, $body, $main_headers);
        mail($to, $subject, "The merchandise listed below was requested by your customer from your link to the Rego Designs website.  Your customer received the following email at " .$order->getEmail() .":\n<br><br><br>\n" . $body, $headers);
        return true;
    } else {
        $to = 'sales@regoonline.com';
        $subject = 'Rego Website Order - ('. $consumer->getRetailerID() .')';
        $headers = $main_headers . 'From: Rego Designs <sales@regoonline.com>' . "\r\n";
        mail($to, $subject, $body, $headers);
        return true;
    }
}