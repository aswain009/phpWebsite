<?php require('manage/includes/settings.php');

if($_POST['dealerSubmit']){
    $message = processDealerAccount($_POST);
}

use a3smedia\utilities\Database;

define('PRODUCT_IMAGE_URL', 'images/products/');
define('PRODUCT_IMAGE_PATH', '/var/www/beta/images/products/');

$orderObj = new regodesign\store\Orders;
$prodOrderObj = new regodesign\store\OrderProducts;
$statusObj = new regodesign\store\Statuses;
$consumer = regodesign\users\Consumers::readConsumerByID($_SESSION['id']);
$productFeed = $orderObj->readOrderByID($_GET['id']);
$customer = regodesign\users\Consumers::readConsumerByNumber($productFeed->getCustomerID());

//$status = array('0' => 'Processing', '1' => 'Shipped', '2' => 'Completed');

include('includes/header.php'); ?>
<style>
.orderProducts {
    display: block;
}
</style>
<h3>ORDER REVIEW</h3>
<div class="row">
    <div style="float: left; width: 75%">
        <p><?= $consumer->getFullName() ?></p>
        <p><?= $consumer->getAddressStreet() ?></p>
        <p><?= $consumer->getAddressCity() ?>, <?= $consumer->getAddressState() ?> <?= $consumer->getAddressZip() ?></p>
    </div>
    <div style="float: left; width: 25%">
        <p>Order #<?= filter_input(INPUT_GET, 'id');?></p>
        <p>Placed by <?= $productFeed->takenBy ?></p>
        <p>PO #<?= $productFeed->getPONumber() ?></p>
    </div>
</div>
<div class="row">
    <table class="order-detail-table">
        <thead>
            <tr>
                <td>Qty</td>
                <td>Item</td>
                <td>Description</td>
                <td>Special Comments</td>
                <!-- <td>Price</td> -->
                <td>Image</td>
                <td>Shipped</td>
            </tr>
        </thead>
        <tbody>
            <?php $productFeed = $prodOrderObj->readProductsByOrder($_GET['id']);
            foreach ($productFeed as $product):
                $prodObj = new regodesign\store\Products;
                $item = $prodObj->readProductBySKU($product->getProductID());
                if (!$item) {
                    $item = $prodObj;
                    $product_image = 'images/logo.jpg';
                } else {
                    $product_image = $item->getImage();
                } ?>
                <tr>
                    <td><?= $product->getQuantity() ?></td>
                    <td>
                        <?php if ($product->getProductID() !== 'Job'): ?>
                            <a href="product.php?id=<?= $product->getProductID() ?>"><?= $product->getProductID() ?></a>
                        <?php else: ?>
                            <?= $product->getProductID() ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $product->getInstructions() ?></td>
                    <td><?= $product->getComments() ?></td>
                    <!-- <td>$<?= number_format($item->getPrice(), 2) ?></td> -->
                    <td><img src="<?= $product_image ?>" height="100" /></td>
                    <td><?= $product->getTracking() ?><br><?= $product->shipMethod ?><br><?= $product->shipDate!=='1900-01-01' ? $product->shipDate : '' ?></td>
                </tr><!--.productItem-->
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include('includes/footer.php'); ?>