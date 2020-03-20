<?php
session_start();
include('includes/settings.php');
include('includes/functions.php');

$_SESSION['page'] = Array(
	'name' => 'Dashboard',
	'link' => 'dashboard.php'
); ?>

<!doctype html>
<html>
<head>
	<title>Rego Design - <?php echo $_SESSION['page']['name']; ?></title>
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
							<div class="box-content nopadding">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
