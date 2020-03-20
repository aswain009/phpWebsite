<?php include('includes/settings.php');
include(INCLUDE_DIR.'functions.php');

//Quicker way to add more pages by having the suffix file names assuming one keeps it consistent
//Ex. view_SUFFIXPLURAL_.php, Ex. get_SUFFIXSINGULAR_
$singular = 'Consumer';
$plural = 'Consumers';
$function = 'get'.$singular; //Variable function name

$_SESSION['page'] = Array(
	'name' => 'View '.$plural,
	'link' => 'view'.$plural.'.php'
);

if(isset($_GET['logout'])){
	unset($_SESSION['_admin']);
	header('Location: index.php');
}

if(!isset($_SESSION['_admin'])){
	header('Location: index.php');
} 

//perform delete
if(isset($_POST['delete'.$singular])) {
	$function('delete', $_POST['delete'.$singular]);
}

//perform edit
if(isset($_POST['edit'.$singular])) {
	$values = $_POST;
	$function('update', $_POST['edit'.$singular], $values);
}

//perform add
if(isset($_POST['add'.$singular])) {
	$values = $_POST;
	$function('create', $_POST['add'.$singular], $values);
}

$data = $function('readAll');

?>
<!doctype html>
<html>

<head>
	<title>Rego Designs - <?php echo $_SESSION['page']['name']; ?></title>
	<?php include('includes/libraries.php'); ?>
</head>

<body data-layout-sidebar="fixed" data-layout-topbar="fixed">

	<div id="purchased<?=$singular; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>
	
	<div id="delete<?=$singular; ?>" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			</div>
		</div>
	</div>

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

				<?php if($_SESSION['_error'] != ''){
					echo '<div id="dashboardError">'.$_SESSION['_error'].'</div>';
					unset($_SESSION['_error']);
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

								&nbsp;&nbsp;&nbsp;&nbsp;<a href="add<?=$plural; ?>.php" role="button" class="btn">Add <?=$singular; ?></a>
							</div>
							<!-- view <?=$singular; ?> table -->
							<div class="box-content nopadding">
								<table class="table table-hover table-nomargin dataTable table-bordered">
									<thead>
										<tr>
											<th title="">Username</th>
											<th title="">Retailer</th>
											<th title="">Full Name</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($data as $row) {
										$retailer = getRetailer('readByID', $row->getRetailerID());

										echo '<tr>'."\n";
										echo '	<td>'.$row->getUsername().'</td>'."\n";
										echo '	<td><a href="editRetailers.php?retailerID='.$retailer->getID().'">'.$retailer->getName().'</a></td>';
										echo '	<td>'.$row->getFullName().'</td>'."\n";
										echo '	<td>';

										echo '		<a href="editConsumers.php?'.strtolower($singular).'ID='.$row->getID().'" role="button" class="btn">Edit</a>';

										echo '		<a href="ajax/delete.php?delete'.$singular.'='.$row->getID().'" data-target="#delete'.$singular.'" role="button" class="btn" data-toggle="modal">Delete</a>';
										echo '	</td>'."\n";
										echo '</tr>'."\n";
									} ?>
									</tbody>
								</table>
							</div>
							<!-- view <?=$singular; ?> table -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	/*$(document).on("hidden.bs.modal", function (e) {
	    $(e.target).removeData("bs.modal").find(".modal-content").empty();
	});*/
	</script>
</body>

</html>