<?php
include('includes/settings.php');
include('includes/functions.php');
//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Product';
$plural = 'Products';
$function = 'get'.$singular;
$_SESSION['page'] = Array(
	'name' => 'Add '.$singular,
	'link' => 'add'.$plural.'.php'
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
$categories = array('Bridal', 'Remounts', 'Anniversary Bands', 'Wraps & Jackets', 'Diamond Fashion', 'Diamond Pendants & Earrings', 'Gems of Distinction', 'Color Rings', 'Color Pendants & Earrings', 'Bracelets', 'Diamond Studs', 'Stackables');
?>
<form method="POST" action="view<?=$plural; ?>.php" id="<?=strtolower($singular); ?>Form">
	<div class="modal-body">
		<ul>
			<li>* Required Fields</li>
			<li>SKU will not be editable after creation of product</li>
		</ul>
		


		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productSKU">* SKU</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productSKU" id="productSKU" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productName">* Name</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productName" id="productName" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productCategory">* Category</label>
				</div>
				<div class="col-sm-8">
					<select name="productCategory" id="productCategory" class="form-control col-sm-8">
						<option value="">Select a Category</option>
						<?php foreach($categories as $category){
							echo '<option>'.$category.'</option>';
						} ?>
					</select>
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-12">
					<label for="productDescription">Description</label>
				</div>
				<div class="col-sm-12">
					<textarea name="productDescription" id="productDescription" class="form-control col-sm-12" rows="10"></textarea>
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productPrice">* Price</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productPrice" id="productPrice" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productCost">* Cost</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productCost" id="productCost" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productWeight">Weight</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productWeight" id="productWeight" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productQty">Quantity</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productQty" id="productQty" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productMinSaleQty">Min Sale Quantity</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productMinSaleQty" id="productMinSaleQty" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productImage">Image</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productImage" id="productImage" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<br/>		

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productStatus">* Status</label>
				</div>
				<div class="col-sm-8">
					<input type="radio" name="productStatus" id="productStatusOn" value="1" checked="checked" /><label for="productStatusOn">On</label><br/>
					<input type="radio" name="productStatus" id="productStatusOFf" value="0" /><label for="productStatusOff">Off</label>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productVisibility">* Visibility</label>
				</div>
				<div class="col-sm-8">
					<input type="radio" name="productVisibility" id="productStatusOn" value="3" /><label for="productStatusOn">Search Only</label><br/>
					<input type="radio" name="productVisibility" id="productStatusOFf" value="4" checked="checked" /><label for="productStatusOff">Catalog and Search</label>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productLinksRelatedSKU">Links Related SKU</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productLinksRelatedSKU" id="productLinksRelatedSKU" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productLinksCrossSellSKU">Links Cross Sell SKU</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productLinksCrossSellSKU" id="productLinksCrossSellSKU" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="productLinksUpsellSKU">Links Upsell SKU</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="productLinksUpsellSKU" id="productLinksUpsellSKU" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<?php //May not need has_options ?>
		<input type="hidden" name="productHasOptions" value="0" />
		<?php //May not need tax_class_id ?>
		<input type="hidden" name="productTaxClass" value="0" />
		<?php //May not need custom_option_row_title ?>
		<input type="hidden" name="productCustomOptionRow" value="" />

	</div>
	<div class="modal-footer">
		<a href="view<?=$plural; ?>.php">
			<button href="view<?=$plural; ?>.php" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</a>
		<input type="hidden" name="add<?=$singular; ?>" value="0">
		<button type="submit" class="btn btn-primary">Add <?=$singular; ?></button>
	</div>
	
	<script>
	$(function(){
		$('#<?=strtolower($singular); ?>Form').validate({
			rules:{
				productSKU: 'required',
				productName: 'required',
				productCategory: 'required',
				productCost:{
					number: true,
					required: true
				},
				productPrice:{
					number: true,
					required: true
				},
				status: 'required',
				visibility: 'required',

			}
		});
		
		$('#productDescription').editable({
			inlineMode: false,
			height: 200
		});
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