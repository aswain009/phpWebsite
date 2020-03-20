<?php
include('includes/settings.php');
include('includes/functions.php');
//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Retailer';
$plural = 'Retailers';
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
$customers = getCustomer('readAll');
?>
<form method="POST" action="view<?=$plural; ?>.php" id="<?=strtolower($singular); ?>Form">
	<div class="modal-body">
		<ul>
			<li>* Required Fields</li>
		</ul>
		
		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="retailerName">* Name</label>
				</div>
				<div class="col-sm-8">
					<select name="retailerName" id="retailerName" class="form-control col-sm-8">
						<option value="">Select a customer</option>
						<?php foreach($customers as $customer){
							echo '<option value="'.$customer->getID().'">'.$customer->getEmail().'</option>';
						} ?>
					</select>
				</div>
			</div>
		</div>

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
				retailerName: 'required',
				retailerMarkup:{
					number: true
				},
				retailerEmail:{
					required: true,
					email: true
				}
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