<?php
use \regodesign\users\Consumers;
use \regodesign\users\Retailers;
require_once('manage/includes/settings.php');
include('includes/header.php');

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
?>
<div class='row'>
  <div id='search'>
    <form action='search.php' method='GET'>
      <div class="form-group">
        <input id='search-text' name='q' type='text' autofocus>
        <input type='submit' value='SEARCH'>
        <div class="clear"></div>
      </div>
        <?php if($_SESSION['id']){
                $consumer = Consumers::readConsumerByID($_SESSION['id']);

                if (!$_SESSION['autologin']) {
                    $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
                } else {
                    $retailer = Retailers::readRetailerByID($_SESSION['id']);
                }
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
        <div style="font-size: 14px; color: #555; margin-left: -32px; padding-bottom: 8px">Select Categories...</div>
        <button id="search-reset" style="float:right">Reset</button>
    </form>
    <div class='clear'></div>
    <?php if (isset($_SESSION['type'])) include('includes/cart.php'); ?>
    <?php include('includes/recent.php'); ?>
  </div>
  <div id='content'>
    <h3 id='store-category'><?= $category_names[filter_input(INPUT_GET, 'cat')] ?></h3>
    <?php
        $category = filter_input(INPUT_GET, 'cat');
    ?>
    <script>
    $(function() {
      $('#search-text').focus();
      var page = 1;
      function loadPage(page) {
          $.get('store-ajax.php', {'cat': '<?=$category?>', 'page': page})
          .done(function(data) {
            $('#content').append(data);
            if (storageAvailable('sessionStorage')) {
                var storage = window.sessionStorage;
                if (typeof storage.scrollPosition != 'undefined') {
                    window.scroll(0, storage.scrollPosition);
                }
            }
          });
      }

      $('#advanced-search-button').on('click', function() {
        $('#advanced-search').toggle(500);
      });
      loadPage(page);
      page++;
      
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

        $(window).on('beforeunload', function() {
            if (storageAvailable('sessionStorage')) {
                var storage = window.sessionStorage;
                storage.scrollPosition = window.scrollY;
            }
        });
    });
    </script>
  </div>
  <div class='clear'></div>
</div>
<?php include('includes/footer.php'); ?>
