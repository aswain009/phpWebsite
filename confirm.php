<?php
require_once('manage/includes/settings.php');

if($_SESSION['confirm']){
    $confirm = $_SESSION['confirm'];
    unset($_SESSION['confirm']);
} else { 
    header('Location: login.php');
}

include('includes/header.php');
?>

  	<div class="row">
		<div id="search" style="float: left">
			<form action="search.php" method="GET">
			 <input type="text" id="search-text" name="q"><input type="submit" value="SEARCH">
			</form>
		</div>

		<div id="confirm">
      <p><?=$confirm; ?></p>
        <?php if ($_SESSION['type'] == 1): ?>
            <p>Once the order has been processed it will appear in your <a href="orders.php">ORDER HISTORY</a> tab.</p>
        <?php endif; ?>
		</div> <!--#confirm-->
  	</div> <!-- row -->

<?php include('includes/footer.php'); ?>