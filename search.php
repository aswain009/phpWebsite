<?php
use \regodesign\users\Consumers;
use \regodesign\users\Retailers;

require_once('manage/includes/settings.php');
include('includes/header.php');
define('PRODUCT_IMAGE_URL', 'images/products/');
define('PRODUCT_IMAGE_PATH', '/var/www/beta/images/products/');
$category_names = array(
        "bridal" => "Bridal",
        "remounts" => "Remounts",
        "anniversary-bands" => "Anniversary Bands",
        "wraps-jackets" => "Wraps & Jackets",
        "diamond-fashion" => "Diamond Fashion",
        "diamond-pendants-earrings" => "Diamond Pendants & Earrings",
        "gems-of-distinction" => "Gems of Distinction",
        "delivery-color" => "Delivery Color",
        "color-rings" => "Color Rings",
        "color-pendants-earrings" => "Color Pendants & Earrings",
        "bracelets" => "Bracelets",
        "diamond-studs" => "Diamond Studs",
        "stackables" => "Stackables"
    );
?>

<div class="row">
    <div id="search" style="float: left">
          <form action='search.php' method='GET'>
          <div class="form-group">
            <input id='search-text' name='q' type='text' value="<?= filter_input(INPUT_GET, 'q') ?>" autofocus>
            <input type='submit' value='SEARCH'>
            <div class="clear"></div>
          </div><!--.form-group-->

            <?php if($_SESSION['id']){
                    $consumer = Consumers::readConsumerByID($_SESSION['id']);
                    $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
            } if ($retailer): ?>
                <input type="number" name="min-price" id="min-price" placeholder="Min $" value="<?= filter_input(INPUT_GET, 'min-price') ?>">
                <input type="number" name="max-price" id="max-price" placeholder="Max $" value="<?= filter_input(INPUT_GET, 'max-price') ?>">
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
            <div style="font-size: 14px; color: #555; margin-left: -32px; padding-bottom: 8px">Select Categories...</div>
            <button id="search-reset" style="float:right">Reset</button>
        </form>
        <div class='clear'></div>
        <?php if (isset($_SESSION['type'])) include('includes/cart.php'); ?>
        <?php include('includes/recent.php'); ?>
    </div>  
    <h3 id="store-category" style="float: left; margin-left: 30px"><?= $category_names[filter_input(INPUT_GET, 'cat')]; ?></h3>
    <div id="content">
<?php
$q = strtolower(trim(filter_input(INPUT_GET, 'q')));
$search_category = $_GET['search-category'];
$min_price = filter_input(INPUT_GET, 'min-price');
$max_price = filter_input(INPUT_GET, 'max-price');

try {
    $db = \a3smedia\utilities\Database::PDO();
} catch (PDOException $e) {
    echo 'Could not connect to database.';
}

if ($product = \regodesign\store\Products::readProductBySKU($q)) {
    echo '<script>window.location=\'product.php?id='.$product->getSKU().'\';</script>';
} else {
    $query = $db->prepare('SELECT * FROM products WHERE sku LIKE :search ORDER BY has_options DESC, sku ASC');
    $query->bindValue(':search', $q.'___');
    try {
        $query->execute();
    } catch (PDOException $e) {
        echo '<h2>PDO Exception</h2>';
        echo '<p>'.$e->getMessage().'</p>';
    } catch (Exception $e) {
        echo '<h2>Exception</h2>';
        echo '<p>'.$e->getMessage().'</p>';
    }
    $query->setFetchMode(\PDO::FETCH_CLASS, '\regodesign\store\Products');
    if ($products = $query->fetchAll()) {
        echo '<script>window.location=\'product.php?id='.$products[0]->getSKU().'\';</script>';
    } else {
        if ($q !== '') {
            $sql = 'SELECT * FROM products WHERE 1';
            foreach (explode(' ', $q) as $i => $term) {

                $sql .= " AND (LOWER(shortDescription) LIKE :descr$i OR LOWER(stoneType) LIKE :stone$i OR LOWER(metalType) LIKE :metal$i OR LOWER(name) LIKE :name$i OR LOWER(Keywords) LIKE :keywords$i)";
            }
            $sql .= " ORDER BY";
            if ($min_price != '' || $max_price != '') $sql .= " price,";
            $sql .= " itemPosition";
            $query = $db->prepare($sql);
            foreach (explode(' ', $q) as $i => $term) {
                $query->bindValue(":name$i", "%$term%");
                $query->bindValue(":descr$i", "%$term%");
                $query->bindValue(":stone$i", "%$term%");
                $query->bindValue(":metal$i", "%$term%");
                $query->bindValue(":keywords$i", "%$term%");
            }
        } else {
            if ($min_price != '' && $max_price != '') {
                $query = $db->prepare('SELECT * FROM products WHERE price BETWEEN :min_price AND :max_price ORDER BY price, itemPosition');
                $query->bindValue(':min_price', $min_price);
                $query->bindValue(':max_price', $max_price);
            } else if ($min_price != '') {
                $query = $db->prepare('SELECT * FROM products WHERE price > :min_price ORDER BY price, itemPosition');
                $query->bindValue(':min_price', $min_price);
            } else if ($max_price != '') {
                $query = $db->prepare('SELECT * FROM products WHERE price < :max_price ORDER BY price, itemPosition');
                $query->bindValue(':max_price', $max_price);
            } else {
                $query = $db->prepare('SELECT * FROM products ORDER BY itemPosition');
            }
        }

        try {
            $query->execute();
        } catch (PDOException $e) {
            echo '<h2>PDO Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
        } catch (Exception $e) {
            echo '<h2>Exception</h2>';
            echo '<p>'.$e->getMessage().'</p>';
        }
        $query->setFetchMode(\PDO::FETCH_CLASS, '\regodesign\store\Products');

        $returned_skus = array();
        $args = explode(' ', $q);

        while (($product = $query->fetch()) !== false):
            if ($min_price == '') $min_price = PHP_INT_MIN;
            if ($max_price == '') $max_price = PHP_INT_MAX;
            $sku_part = preg_replace('/-\d+/', '', $product->getSKU());
            if ($_SESSION['type'] == 2) { //Only consumers of retailers can see markup price
                $markup = $retailer->getMarkup();  
              } else {
                $markup = 1;
              }
            if (
                $product->getCategory() !== ''
                && $product->getVisibility() == 4
                && ($product->getPrice() * $markup) >= $min_price
                && ($product->getPrice() * $markup) <= $max_price
                && (in_array(array_search($product->getCategory(), $category_names), $search_category) || in_array('all', $search_category) || is_null($search_category))
                && !in_array($sku_part, $returned_skus)
            ):
                $returned_skus[] = $sku_part;
                $count++;
                if ($count > 1024) break; ?>
                
                <div class="store-item">
                    <a class="image-link" href="product.php?id=<?= $product->getSKU() ?>">
                        <img class="product-image" width="200" style="height:auto; max-height:200px" src="<?= $product->getImage() ?>">
                    </a>
                    <a href="product.php?id=<?= $product->getSKU() ?>" class="item-name"><?= $product->getName() ?></a>
                    <?php
                        $price = $product->getPrice();
                        if ($_SESSION['type'] == 2) { //Only consumers of retailers can see markup price
                            $markup = $retailer->getMarkup();  
                        } else {
                            $markup = 1;
                        }
                    ?>
                    <?php if ($retailer): ?>
                        <span class="price">Price:</span><a href="product.php?id=<?= $product->getSKU() ?>" class="add-to-cart">$<?= number_format($price * $markup, 2) ?></a>
                    <?php else: ?>
                        <span class="price">Price:</span><a href="login.php" class="add-to-cart">Login For Price</a>  
                    <?php endif; ?>
                </div>
            <?php endif;?>
        <?php endwhile;
        if ($count == 0) echo '<p>No results found.</p>';
    }
}
?>

<div style="min-height: 800px;"></div>
<script>
function storageAvailable(type) {
    try {
        var storage = window[type],
            x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    }
    catch(e) {
        return false;
    }
}

$(document).on('ready', function() {
    if (storageAvailable('sessionStorage')) {
        var storage = window.sessionStorage;
        if (typeof storage.scrollPosition != 'undefined') {
            if (storage.searchQuery == '<?php echo serialize($_GET); ?>') {
                window.scroll(0, storage.scrollPosition);
            }
        }
    }
});

$(window).on('beforeunload', function() {
    if (storageAvailable('sessionStorage')) {
        var storage = window.sessionStorage;
        storage.searchQuery = '<?php echo serialize($_GET); ?>';
        storage.scrollPosition = window.scrollY;
    }
});

$('#search-text').select().focus();

var cats = "<?php echo implode(',', $_GET['search-category']); ?>";
$('#search-category').val(cats.split(','));
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
<?php include('includes/footer.php'); ?>
