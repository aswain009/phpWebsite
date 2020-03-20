<?php
include('../includes/settings.php');
include('../includes/functions.php');

if(isset($_GET['deleteItem'])) {

	$item = getItems('read', $_GET['deleteItem']); ?>
	<form method="POST" action="viewItems.php">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title" id="myModalLabel">Delete Item</h4>
		</div>

		<div class="modal-body">
			<h2 align="center">Click DELETE to delete <?= $item->getName(); ?></h2>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<input type="hidden" name="deleteItem" value="<?=$item->getID(); ?>">
			<button type="submit" class="btn btn-primary">DELETE</button>
		</div>
	</form>

<?php }