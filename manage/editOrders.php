<?php
include('includes/settings.php');
include('includes/functions.php');
//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Order';
$plural = 'Orders';
$function = 'get'.$singular;
$_SESSION['page'] = Array(
	'name' => 'Edit '.$singular,
	'link' => 'edit'.$plural.'.php'
);

if(isset($_GET['logout'])){
	unset($_SESSION['_admin']);
	header('Location: index.php');
}

if(!isset($_SESSION['_admin'])){
	header('Location: index.php');
} 
?>
<!doctype html>
<html>
<head>
<title>Rego Designs - <?php echo $_SESSION['page']['name']; ?></title>
<?php include('includes/libraries.php'); ?>
</head>
<body data-layout-sidebar="fixed" data-layout-topbar="fixed">
	<!-- top nav begin -->
	<?php include('includes/topNav.php'); ?>
	<!-- top nav end -->
	<div class="container-fluid" id="content">
	
	<!-- side nav begin -->
	<?php include('includes/sideNav.php'); ?>
	<!-- side nav end -->
		<div id="main">
			<div class="container-fluid">
				<div class="page-header">
					<div class="pull-left">
						<h1><?php echo $_SESSION['page']['name']; ?></h1>
					</div>
				</div>
				<div class="breadcrumbs">
					<ul>
						<li>
							<a href="dashboard.php">Dashboard</a>
							<?php
							if($_SESSION['page']['name'] !== 'Dashboard') {
								echo '<i class="fa fa-angle-right"></i>';
							}
							?>
						</li>
						<?php
						if($_SESSION['page']['name'] !== 'Dashboard') {
							echo '<li>
								<a href="'.$_SESSION['page']['link'].'">'.$_SESSION['page']['name'].'</a>
								</li>';
						}
						?>
					</ul>
					<div class="close-bread">
						<a href="#">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<?php if(isset($errorMessage)){
					echo '<div id="dashboardError">'.$errorMessage.'</div>';
				} ?>
				<div class="row">
					<div class="col-sm-12">
						<div class="box">
							<div class="box-title">
								<h3>
									<i class="fa fa-bars"></i>
									<?php
									if($_SESSION['page']['name'] !== 'Dashboard') {
										echo $_SESSION['page']['name'];
									}
									?>
								</h3>
							</div>
<!-- add <?=$plural; ?> table -->
<?php 
$data = getOrder('readByID', $_GET['orderID']);
$statuses = getStatus('readAll');
$consumer = getConsumer('readByID', $data->getCustomerID());
$products = getOrderProducts('readByOrder', $data->getID());
?>
<form method="POST" action="view<?=$plural; ?>.php" id="<?=strtolower($singular); ?>Form" enctype="multipart/form-data">
	<input type="hidden" name="orderCustomerID" value="<?=$data->getCustomerID(); ?>" />
	<input type="hidden" name="orderDate" value="<?=$data->getDate(); ?>" />

	<div class="modal-body">
		<ul class="adminDescriptions">
			<li>* Required Fields</li>
		</ul>
		
		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderCustomerID">Customer</label>
				</div>
				<div class="col-sm-8">
					<p><?=$consumer->getEmail(); ?></p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderDate">Date</label>
				</div>
				<div class="col-sm-8">
					<p><?=$data->getDate(); ?></p>
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderTrackingNo">Tracking No.</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="orderTrackingNo" id="orderTrackingNo" class="form-control col-sm-8" value="<?=$data->getTrackingNo(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderQuantity">* Total Quantity</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="orderQuantity" id="orderQuantity" class="form-control col-sm-8" value="<?=$data->getQuantity(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderShipped">* Total Shipped</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="orderShipped" id="orderShipped" class="form-control col-sm-8" value="<?=$data->getShipped(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="orderStatus">* Status</label>
				</div>
				<div class="col-sm-8">
					<select name="orderStatus" id="orderStatus" class="form-control col-sm-8">
						<?php foreach($statuses as $status){
							if($status->getID() == $data->getStatus()){
								echo '<option value="'.$status->getID().'" selected="selected">'.$status->getID().' - '.$status->getName().'</option>';
							} else {
								echo '<option value="'.$status->getID().'">'.$status->getID().' - '.$status->getName().'</option>';
							}
						} ?>
					</select>
				</div>
			</div>
		</div>

		<hr/>

		<div id="products">
			<h2>Products in Order</h2>
			<?php foreach($products as $product){ 
				$productData = getProduct('readByID', $product->getProductID()); ?>
				<div class="row">
					<div class="form-group">
						<div class="col-sm-12">
							<label for="orderShipped"><?=$productData->getName(); ?></label>
						</div>
						<div class="col-sm-4">
							<p>Qty <input type="text" class="productQuantity" name="quantity[<?=$productData->getSKU(); ?>]" value="<?=$product->getQuantity(); ?>" data-rule-digits="true" data-rule-required="true" /></p>
						</div>

						<div class="col-sm-4">
							<p>Shipped <input type="text" class="productShipped" name="shipped[<?=$productData->getSKU(); ?>]" value="<?=$product->getShipped(); ?>" data-rule-digits="true" data-rule-required="true" /></p>
						</div>
					</div>
				</div>

				<br/>
			<?php } ?>
		</div><!--#products-->

		<input type="hidden" name="quantityTotal" id="quantityTotal" value="" />
		<input type="hidden" name="shippedTotal" id="shippedTotal" value="" />
		
	</div>
	<div class="modal-footer">
		<a href="view<?=$plural; ?>.php">
			<button href="view<?=$plural; ?>.php" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</a>
		<input type="hidden" name="edit<?=$singular; ?>" value="<?=$data->getID(); ?>" />
		<button type="submit" class="btn btn-primary">Edit <?=$singular; ?></button>
	</div>
	
	<script>
	$(function(){

		//Initialize
		var quantityTotal = 0;
		var shippedTotal = 0;
		quantityShipped();

		//Anytime these text fields are changed, reprocess the totals of their corresponding value
		$('.productQuantity').change(function(){
			quantityShipped();
		});

		$('.productShipped').change(function(){
			quantityShipped();
		});

		

		

		$('#<?=strtolower($singular); ?>Form').validate({
			//http://stackoverflow.com/questions/4156310/jquery-validator-dynamic-parameters
			rules:{
				orderQuantity:{
					required: true,
					number: true,
					quantity: 0 //Disregard the 0 with the newly added rules for these two fields
					
				},
				orderShipped:{
					required: true,
					number: true,
					shipped: 0 //Disregard the 0 with the newly added rules for these two fields
				},
				orderStatus: 'required'
			}

			//Rules for the individual products are inline attributes
		});

		//Loop through product quantity and shipped amounts
		function quantityShipped(){
			quantityTotal = 0;
			shippedTotal = 0;
			console.log('Changing numbers');

			$('#products .row').each(function(){
				//Find the input and parse to int
				var quantity = parseInt($(this).find('div').find('div').next('div').find('input').val());
				quantityTotal = quantityTotal + quantity;

				//console.log(quantity);

				var shipped = parseInt($(this).find('div').find('div').next('div').next('div').find('input').val());
				shippedTotal = shippedTotal + shipped;

				//console.log(shipped);
			});

			console.log(quantityTotal);
			console.log(shippedTotal);

			//Plug these values into the hidden fields just for the added rules for validation
			$('#quantityTotal').val(quantityTotal);
			$('#shippedTotal').val(shippedTotal);
		}

		//The functions are ignoring the third argument, the parameter, as it struggles to deal with dynamic values.
		$.validator.addMethod('quantity', function(value, element, quantityTotal){
			return this.optional(element) || parseInt(value) == $('#quantityTotal').val();
		}, $.validator.format('Please make sure all item quantities match order quantity'));

		$.validator.addMethod('shipped', function(value, element, shippedTotal){
			return this.optional(element) || parseInt(value) == $('#shippedTotal').val();
		}, $.validator.format('Please make sure all item shipped match order shipped'));
	});
	</script>
</form>
<!-- add <?=$plural; ?> table -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).on("hidden.bs.modal", function (e) {
	    $(e.target).removeData("bs.modal").find(".modal-content").empty();
	});
	</script>
</body>
</html>