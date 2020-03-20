<?php
    use \regodesign\store\Products;
    if(!isset($_SESSION['history'])) $_SESSION['history'] = array();
    $_SESSION['history'] = array_slice(array_unique($_SESSION['history']), -5, 5);
    
    define('PRODUCT_IMAGE_URL', 'images/products/');
    define('PRODUCT_IMAGE_PATH', '/var/www/beta/images/products/');
?>
<div style="text-align:left">
    <h2 style="margin-bottom:8px">Recently Viewed</h2>
    <?php foreach (array_reverse($_SESSION['history']) as $sku): ?>
        <?php 
        $recent_product = Products::readProductBySKU($sku);
    ?>

        <a style="font-size: 12px; display: flex; align-items: center" href="product.php?id=<?= $sku ?>"><img width="84" src="<?= $recent_product->getImage() ?>"><?= $recent_product->getSKU() ?></a>
    <?php endforeach; ?>
</div>