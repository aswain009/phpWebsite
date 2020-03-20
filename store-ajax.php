<?php
use \regodesign\users\Consumers;
use \regodesign\users\Retailers;
use \regodesign\store\Products;

// error_reporting(0);
session_start();
require_once('autoloader.php');

define('PRODUCT_IMAGE_URL', 'images/products/');
define('PRODUCT_IMAGE_PATH', '/var/www/beta/images/products/');

$category = filter_input(INPUT_GET, 'cat');
$page = filter_input(INPUT_GET, 'page');

$db = \a3smedia\utilities\Database::PDO();
$query = $db->prepare("SELECT * FROM `categories` WHERE `slug` = ?");
$query->execute(array($category));
$category = $query->fetch();

if ($category):
    if($_SESSION['id']) {
        $consumer = Consumers::readConsumerByID($_SESSION['id']);
        $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
    }

    // paged results set
    $products = Products::readProductByCategory($category['name']);
    //all results at once
    //$products = Products::readProductByCategory($category);
    
    foreach ($products as $product):
        $price = $product->getPrice();
        if ($_SESSION['type'] == 2) {
            $markup = ($retailer->getMarkup());  
        } else {
            $markup = 1;
        }
        $price = '$'.number_format($price * $markup, 2);

        if ($product->getVisibility() == 4): ?>

            <div class="store-item">
                <a class="image-link" href="product.php?id=<?= $product->getSKU() ?>">
                    <img class="product-image" width="200" style="height: auto; max-height:200px;" src="<?= $product->getImage() ?>">
                </a>
                <a href="product.php?id=<?= $product->getSKU() ?>" class="item-name"><?= $product->getName() ?></a>
            <?php if ($retailer): ?>
                <span class="price">Price:</span><a href="product.php?id=<?= $product->getSKU() ?>" class="add-to-cart"><?= $price ?></a>
            <?php else: ?>
                <span class="price">Price:</span><a href="product.php?id=<?= $product->getSKU() ?>" class="add-to-cart">Login For Price</a>  
            <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>