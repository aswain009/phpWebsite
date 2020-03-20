<?php
require_once('manage/includes/settings.php');
include('includes/header.php');
use \regodesign\store\Carts;
use \regodesign\store\Products;
use \regodesign\users\Consumers;
use \regodesign\users\Retailers;

$category_names = array(
    "bridal" => "Bridal",
    "remounts" => "Remounts",
    "anniversary-bands" => "Anniversary Bands",
    "wraps-jackets" => "Wraps & Jackets",
    "diamond-fashion" => "Diamond Fashion",
    "diamond-pendants-earrings" => "Diamond Pendants & Earrings",
    "gems-of-distinction" => "Gems Of Distinction",
    "delivery-color" => "Delivery Color",
    "color-rings" => "Color Rings",
    "color-pendants-earrings" => "Color Pendants & Earrings",
    "bracelets" => "Bracelets",
    "diamond-studs" => "Diamond Studs",
    "stackables" => "Stackables"
);
unset($product);
$product = Products::readProductBySKU($_GET['id']);
$_SESSION['history'][] = $product->getSKU();
?>
  	<div class="row">
		<div id="search" style="float: left">
            <form action='search.php' method='GET'>
                <div class="form-group">
                    <input id='search-text' name='q' type='text' autofocus>
                    <input type='submit' value='SEARCH'>

                    <div class="clear"></div>
                </div><!--.form-group-->

                <?php if($_SESSION['id']){
                        $consumer = Consumers::readConsumerByID($_SESSION['id']);
                        $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
                } if ($retailer): ?>
                    <input type="number" name="min-price" id="min-price" placeholder="Min $">
                    <input type="number" name="max-price" id="max-price" placeholder="Max $">
                <?php endif; ?>
                <div class="form-group" id="search-category-wrapper">
                    <select id="search-category" name="search-category[]" class="chosen-select" multiple>
                        <option value="all" <?php if (in_array('all', $_GET['search-category'])) echo 'selected'; ?>>All Categories</option>
                        <?php foreach ($category_names as $k=>$v): ?>
                            <?php $selected = ''; if (in_array($k, $_GET['search-category'])) $selected = 'selected';?>
                            <option value="<?= $k ?>" <?= $selected ?>><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div><!--.form-group-->
                <div style="font-size: 14px; color: #555; margin-left: -32px; padding-bottom: 8px">
                    <span>Select Categories...</span>
                </div>
                <button id="search-reset" style="float:right">Reset</button>
            </form>
            <div class='clear'></div>
            <?php if (isset($_SESSION['type'])) include('includes/cart.php'); ?>
            <?php include('includes/recent.php'); ?>
		</div>
        <div class="content" id="productContent">
            <div class="left">
                <div class="product-img-box">
                        <a class="MagicZoom" data-options="zoomPosition: inner; zoomOn: click; expand: on;" href="<?= $product->getImage() ?>" id="product-image">
                            <img class="product-image-main" src="<?= $product->getImage() ?>" />
                        </a>
                </div>
                <?php if (stripos($product->getShortDescription(), 'semi') !== false): ?>
                    <p style="color: #0000F0;">Semi-Mount Piece- Center Stone Not Included</p>
                <?php endif; ?>
                <table class="description">
                    <tr>
                        <td><b>Item Number</b></td>
                        <td><?= $product->getSKU() ?></td>
                    </tr>
                    <tr>
                        <td><b>Description</b></td>
                        <td><?php echo $product->getShortDescription(); ?></td>
                    </tr>
                    <tr>
                        <td><b>Stones</b></td>
                        <td><?= $product->getStoneType() ?></td>
                    </tr>
                    <?php if (!empty($product->getDefaultCenterSize())): ?>
                        <tr>
                            <td><b>Center Size</b></td>
                            <td><?= $product->getDefaultCenterSize() ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td><b>Diamond Weight</b></td>
                        <td><?= $product->getDiamondWeight() ?></td>
                    </tr>
                    <tr>
                        <td><b>Metal</b></td>
                        <td><?= $product->getMetalType() ?></td>
                    </tr>
                    <tr>
                        <td><b>Partner</b></td>
                        <td>
                            <?php foreach ($product->getPartnerPiece() as $partner): ?>
                                <?php preg_match('/(\w+)/', $partner, $sku); ?>
                                <a href="product.php?id=<?= $sku[0] ?>-01"><?= $partner ?></a><br>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
                <select id="additional-options">
                    <option selected disabled>Additional Options</option>
                    <?php for ($i = 1; $i < 100; $i++): ?>
                        <?php $option = Products::readProductBySKU(sprintf('%s-%02d', substr($_GET['id'], 0, -3), $i)); ?>
                        <?php if (is_object($option) && $option->getHasOptions()): ?>
                            <option value="product.php?id=<?= $option->getSKU() ?>">
                                <?php 
                                    if ($_SESSION['type'] == 2) {
                                        $price = $option->getPrice() * $retailer->getMarkup();
                                        $price = ' $'.number_format($price, 2);
                                    } else {
                                        $price = $option->getPrice();
                                        $price = ' $'.number_format($price, 2);
                                    }
                                    if (!isset($_SESSION['type'])) {
                                        $price = '';
                                    }
                                ?>
                                <?= $option->getSKU().' '.$option->getDropDescription().$price ?>
                            </option>
                        <?php endif; ?>
                    <?php endfor; ?>
                </select>
                <script>
                    $('#additional-options').on('change', function() {
                        window.location = $('#additional-options').val();
                    });
                    $('#search-category').val('all');
                    $('#search-category').trigger('chosen:updated');
                    $('#search-reset').on('click', function(e) {
                        e.preventDefault();
                        $('#search-text').val('');
                        $('#min-price').val('');
                        $('#max-price').val('');
                        $('#search-category').val('all');
                        $('#search-category').trigger('chosen:updated');
                      });
                      $('#search-category').chosen({
                        placeholder_text_multiple: 'Search categories...'
                      });
                </script>

            </div>
            <div class="right">
                <!-- <h3><?= $product->getName() ?></h3> -->
                <?php if ($retailer):
                    $qty = Carts::readCartExist($consumer->getID(), $product->getSKU());
                    if (empty($qty)) { 
                        $qty = 1; //If nothing, then set to 1 in the quantity text field
                    }
                    if ($_SESSION['type'] == 2): //Consumers should see the markup change
                        $price = $product->getPrice() * $retailer->getMarkup();
                    ?> 
                        <p>Price: $<?= number_format($price, 2) ?></p>
                    <?php else: ?>
                        <p>Price: $<?= number_format($product->getPrice(), 2) ?></p>
                    <?php endif; ?>
                    
                    <form id="addToCartForm" action="add-to-cart.php" method="POST">
                        <input type="hidden" name="productID" value="<?= $product->getSKU() ?>" />
                        <input type="hidden" name="consumerID" value="<?= $_SESSION['id'] ?>" />
                        <?php if (!in_array($product->getCategory(),
                            ['Diamond Pendants & Earrings', 'Color Pendants & Earrings', 'Bracelets', 'Diamond Studs'])): ?>
                            <div class="formGroup">
                                <label for="ring-size">Ring Size: </label>
                                <select id="ring-size" name="ring-size">
                                    <option value="stock">Stock</option>
                                    <?php for ($i = 1; $i <= 18; $i+=0.25): ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <br>
                        <?php endif; ?>
                        <div class="formGroup">
                            <label for="quantity">Quantity: </label>
                            <input type="text" name="quantity" id="quantity" size="5" value="1" />
                        </div>
                        <div class="formInput">
                            <p>Special Instructions:</p>
                            <textarea name="special" id="special"></textarea>
                        </div>
                        <input type="submit" name="submit" value="Add to Cart" />
                    </form><!--#addToCartForm-->
                <?php else: ?>
                    <a href="login.php">Login for Price</a>
                <?php endif; ?>
                <div class="product-thumbs">
                <?php
                            // $img_base = substr($product->getImage(), 0, -5);
                            // $img_ext = substr($product->getImage(), -4);
                            // $gallery_images = array(
                            //     $img_base . '1' . $img_ext,
                            //     $img_base . '2' . $img_ext,
                            //     $img_base . '3' . $img_ext,
                            //     $img_base . '4' . $img_ext,
                            //     $img_base . '5' . $img_ext,
                            // );
                            
                            function image_exists($url) {
                                $file = str_replace('http://regodesigns.com/', '/var/www/', $url);
                                return file_exists($file);
                            }
                            
                            if (strpos($product->getImage(), '-1') !== false) {
                                $gallery_images = array();
                                for ($i = 1; $i < 5; $i++) {
                                    $gallery_images[] = preg_replace('/\d(\.\w{3})/', "$i$1", $product->getImage());
                                }
                            } else {
                                $gallery_images = array();
                                $gallery_images[] = $product->getImageBase();
                                for ($i = 1; $i < 5; $i++) {
                                    $gallery_images[] = preg_replace('/(\.\w{3})/', "_v$i$1", $product->getImageBase());
                                }
                            }
                            foreach ($gallery_images as $image):
                                if (image_exists($image)): ?>
                                    <a href="<?= $image ?>" data-zoom-id="product-image" data-image="<?= $image ?>">
                                        <img src="<?= $image ?>" width="56" alt="<?= $product->getSKU() ?>" />
                                    </a>
                                <?php
                                endif;
                            endforeach;
                        ?>
                </div>
                <div class="social">
                    <span class='st_sharethis_large' displayText='ShareThis'></span>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_linkedin_large' displayText='LinkedIn'></span>
                    <span class='st_pinterest_large' displayText='Pinterest'></span>
                    <span class='st_email_large' displayText='Email'></span>
                </div>
                <script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "d1224c15-c83e-4ef7-b786-50984cf952e9", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
            </div>
        </div> <!--#productContent-->
        <div class="clear"></div>
    </div>
<?php include('includes/footer.php'); ?>