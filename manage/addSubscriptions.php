<?php
include('includes/settings.php');
include('includes/functions.php');
//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Subscription';
$plural = 'Subscriptions';
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
$intervals = array('day', 'week', 'month', 'year');
?>
<form method="POST" action="view<?=$plural; ?>.php" id="<?=strtolower($singular); ?>Form">
	<div class="modal-body">
		<ul>
			<li>* Required Fields</li>
			<li>Interval: The type of duration of time for the subscription</li>
			<li>Count: The number of durations for the interval</li>
			<li>The max duration for a subscription is a year (Stripe)</li>
			<li>Amount: The cost (in cents) of the full subscription</li>
			<li>Statement: What the subscriber will see on their billing invoices (22 character limit)</li>
		</ul>
		


		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="subscriptionName">* Name</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="subscriptionName" id="subscriptionName" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="subscriptionInterval">* Intervals</label>
				</div>
				<div class="col-sm-8">
					<select name="subscriptionInterval" id="subscriptionInterval" class="form-control col-sm-8">
						<?php foreach($intervals as $interval){
							echo '<option value="'.$interval.'">'.ucfirst($interval).'</option>';
						} ?>
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="subscriptionAmount">* Amount</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="subscriptionAmount" id="subscriptionAmount" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="subscriptionCount">* Count</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="subscriptionCount" id="subscriptionCount" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-4">
					<label for="subscriptionStatement">Statement</label>
				</div>
				<div class="col-sm-8">
					<input type="text" name="subscriptionStatement" id="subscriptionStatement" maxlength="22" class="form-control col-sm-8">
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-sm-12">
					<label for="subscriptionDescription">Description</label>
				</div>
				<div class="col-sm-12">
					<textarea name="subscriptionDescription" id="subscriptionDescription" class="form-control col-sm-12" rows="10"></textarea>
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
				subscriptionName: 'required',
				subscriptionInterval: 'required',
				subscriptionAmount:{
					required: true,
					digits: true
				},
				subscriptionCount:{
					required: true,
					digits: true
				},
			}
		});
		
		$('#subscriptionDescription').editable({
			inlineMode: false,
			height: 200
		})
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