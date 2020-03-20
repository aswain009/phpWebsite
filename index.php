<?php 
require_once('includes/settings.php');
include('includes/header.php'); ?>


  <div class="home row" style="text-align:center">
    <?php if($retailer && !empty($retailer->getBanner())): ?>
        <img src="images/banners/<?= $retailer->getBanner() ?>">
    <?php else: ?>
        <img width="100%" src="images/rego-home.png">
    <?php endif; ?>
  </div>

<?php include('includes/footer.php'); ?>