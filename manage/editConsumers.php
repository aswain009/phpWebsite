<?php
include('includes/settings.php');
include('includes/functions.php');
//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Consumer';
$plural = 'Consumers';
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
$retailers = getRetailer('readAll');
$types = array('Consumer' => 2, 'Retailer' => 1);
$data = getConsumer('readByID', $_GET['consumerID']);
?>
<form method="POST" action="view<?=$plural; ?>.php" id="<?=strtolower($singular); ?>Form">
	<div class="modal-body">
		<ul>
			<li>* Required Fields</li>
			<li>Types<ul>
				<li>Retailer: The main consumer account associated to the retailer; they will have the option to change the retail account</li>
				<li>Consumer: Customers associated to a retailer with limited access</li>
			</ul></li>
		</ul>
		
		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerRetailer">* Retailer</label>
				</div>
				<div class="col-sm-8">
					<select name="consumerRetailer" id="consumerRetailer" class="form-control col-sm-8">
						<option value="">Select a Retailer</option>
						<?php foreach($retailers as $retailer){
							if($retailer->getID() == $data->getRetailerID()){
								echo '<option value="'.$retailer->getID().'" selected="selected">'.$retailer->getName().'</option>';
							} else {
								echo '<option value="'.$retailer->getID().'">'.$retailer->getName().'</option>';
							}
						} ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerType">* Type</label>
				</div>
				<div class="col-sm-8">
					<select name="consumerType" id="consumerType" class="form-control col-sm-8">
					<option value="">Select a type</option>
						<?php foreach($types as $key => $value){
							if($value == $data->getType()){
								echo '<option value="'.$value.'" selected="selected">'.$key.'</option>';	
							} else {
								echo '<option value="'.$value.'">'.$key.'</option>';	
							}
							
						} ?>
					</select>
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerID">* ID</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerID" id="consumerID" readonly="readonly" class="form-control col-sm-8" value="<?=$data->getID(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerUsername">* Username</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerUsername" id="consumerUsername" class="form-control col-sm-8" value="<?=$data->getUsername(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerPassword">Password</label>
				</div>
				<div class="col-sm-8">
					<input type="password" name="consumerPassword" id="consumerPassword" class="form-control col-sm-8" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerConfirm">Confirm</label>
				</div>
				<div class="col-sm-8">
					<input type="password" name="consumerConfirm" id="consumerConfirm" class="form-control col-sm-8" />
				</div>
			</div>
		</div>

		<br/>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerFullName">* Full Name</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerFullName" id="consumerFullName" class="form-control col-sm-8" value="<?=$data->getFullName(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerAddressStreet">* Street Address</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerAddressStreet" id="consumerAddressStreet" class="form-control col-sm-8" value="<?=$data->getAddressStreet(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerAddressSuite">Suite</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerAddressSuite" id="consumerAddressSuite" class="form-control col-sm-8" value="<?=$data->getAddressSuite(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerAddressCity">* City</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerAddressCity" id="consumerAddressCity" class="form-control col-sm-8" value="<?=$data->getAddressCity(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerAddressState">* State</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerAddressState" id="consumerAddressState" class="form-control col-sm-8" value="<?=$data->getAddressState(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerAddressZip">* Zip</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerAddressZip" id="consumerAddressZip" class="form-control col-sm-8" value="<?=$data->getAddressZip(); ?>" />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="consumerPhone">* Phone</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="consumerPhone" id="consumerPhone" class="form-control col-sm-8" value="<?=$data->getPhone(); ?>" />
				</div>
			</div>
		</div>

		
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

		$('#<?=strtolower($singular); ?>Form').validate({
			rules:{
				consumerID: 'required',
				consumerRetailer: 'required',
				consumerType: 'required',
				consumerUsername: 'required',
				consumerConfirm:{
					equalTo: '#consumerPassword'
				},
				consumerFullName: 'required',
				consumerAddressStreet: 'required',
				consumerAddressCity: 'required',
				consumerAddressState: 'required',
				consumerAddressZip: 'required',
				consumerAddressPhone: 'required'
			}
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