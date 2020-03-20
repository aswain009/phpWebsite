<?php session_start();
include('includes/settings.php');
use a3smedia\utilities\Database;

if($_POST['login'] && empty($_POST['larvelplop'])){

	$email = $_POST['loginEmail'];
	$pass = $_POST['loginPassword'];

	$adminObj = new regodesign\users\Admins;
	$check = $adminObj->readAdminByEmail($email);

	if($check){
		$hash = Database::hash($pass, $check->getSalt());
		if($check->getPassword() == $hash['hash']){
			$_SESSION['_admin'] = $check->getID();
			header('Location: dashboard.php');
		} else {
			$msg = 'Incorrect email or password';
		}
	} else {
		$msg = 'Incorrect email or password';
	}

} ?>

<!doctype html>
<html>
	<head>
		<title><?=SITE_NAME; ?></title>
		<?php include('includes/libraries.php'); ?>
	</head>

	<body class='login'>
		<div class="wrapper">
			<h1>
				<a href="index.php">
					<img src="assets/img/logo-big.png" alt="" class='retina-ready' width="59" height="49"><?=SITE_NAME; ?></a>
			</h1>

			<div class="login-body">
				<h2>SIGN IN</h2>
				<?php
				if(isset($msg)) {
					echo '<p align="center">'.$msg.'</p>';
				}
				?>
				<form action="index.php" method='POST' class='form-validate' id="test">
					<input type="text" name="larvelplop" value="" style="display: none;" />
					<div class="form-group">
						<div class="email controls">
							<input type="text" name='loginEmail' placeholder="Email Address" class='form-control' data-rule-required="true">
						</div>
					</div>
					<div class="form-group">
						<div class="pw controls">
							<input type="password" name="loginPassword" placeholder="Password" class='form-control' data-rule-required="true">
						</div>
					</div>
					<div class="submit">
						<input type="submit" name="login" value="Sign me in" class='btn btn-primary'>
					</div>
				</form>
				<div class="forget">
					<a href="#">
						<span>Forgot password?</span>
					</a>
				</div>
			</div>
		</div>
	</body>
</html>