<?php //Collection of delete modals
include('../includes/settings.php');
include('../includes/functions.php');

if(isset($_GET['deleteConsumer'])) {

	$consumer = getConsumer('readByID', $_GET['deleteConsumer']); ?>
	<form method="POST" action="viewConsumers.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Consumer</h4>
		</div>

		<div class="modal-body">
			<h2 align="center">Click DELETE to delete <?= $consumer->getFullName(); ?></h2>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="hidden" name="deleteConsumer" value="<?=$consumer->getID(); ?>">
			<button type="submit" class="btn btn-primary">DELETE</button>
		</div>
	</form>

<?php } 

if(isset($_GET['deleteProduct'])) {

	$product = getProduct('readByID', $_GET['deleteProduct']); ?>
	<form method="POST" action="viewProducts.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Product</h4>
		</div>

		<div class="modal-body">
			<h2 align="center">Click DELETE to delete <?= $product->getSKU(); ?></h2>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="hidden" name="deleteProduct" value="<?=$product->getSKU(); ?>">
			<button type="submit" class="btn btn-primary">DELETE</button>
		</div>
	</form>

<?php } 

if(isset($_GET['deleteRetailer'])) {

	$retailer = getRetailer('readByID', $_GET['deleteRetailer']); ?>
	<form method="POST" action="viewRetailers.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Retailer</h4>
		</div>

		<div class="modal-body">
			<h2 align="center">Click DELETE to delete <?= $retailer->getName(); ?></h2>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="hidden" name="deleteRetailer" value="<?=$retailer->getID(); ?>">
			<button type="submit" class="btn btn-primary">DELETE</button>
		</div>
	</form>

<?php } 

if(isset($_GET['deleteAdmin'])) {

	$admin = getAdmin('readByID', $_GET['deleteAdmin']); ?>
	<form method="POST" action="viewAdmins.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Admin</h4>
		</div>

		<div class="modal-body">
			<h2 align="center">Click DELETE to delete <?= $admin->getEmail(); ?></h2>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="hidden" name="deleteAdmin" value="<?=$admin->getID(); ?>">
			<button type="submit" class="btn btn-primary">DELETE</button>
		</div>
	</form>

<?php } ?>