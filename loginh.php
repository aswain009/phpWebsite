<?php require('manage/includes/settings.php');

use a3smedia\utilities\Database;

if($_POST['submit']){
	if(empty($_POST['aurum'])){
		$username = $_POST['username'];
		$pass = $_POST['password'];

		//Make sure there is data
		$conObj = new regodesign\users\Consumers;
		$consumer = $conObj->readConsumerByUsername($username);

		if ($consumer && $consumer->getUsername()) {
			$sha1 = sha1($pass);

			if ($sha1 == $consumer->getPassword()) {
                session_destroy();
                session_start();
				$retailObj = new regodesign\users\Retailers;
				$retailer = $retailObj->readRetailerByID($consumer->getRetailerID());
                $_SESSION['id'] = $consumer->getID();
                $_SESSION['customer_id'] = $consumer->getCustomerID();
				$_SESSION['type'] = $consumer->getType();
                $_SESSION['logo'] = $retailer->getLogo();
                $_SESSION['autologin'] = false;

                if ($retailer->getBanner() == '') {
                    header('Location: store.php?cat=bridal');
                } else {
                    header('Location: index.php');
                }
			} else {
				$message = 'Invalid username or password';
			}
		} else {
			$message = 'Invalid username or password';
		}
	} else {
		$message = 'Login attempt flagged as spam';
	}
} ?>

<?php include('includes/header.php'); ?>
<h3>DEALER LOGIN</h3>

<div class="row">
	<div class="c50" style="padding-right: 40px">
		<p>Jewelry is a gift that should last a lifetime.  Enduring style and quality are the only characteristics that can ensure longevity.</p>

		<p>For more than 40 years, Rego has supplied the finest independent jewelry stores in America with jewelry that stands the test of time.  Our craftsmanship is unparalleled and our manufacturing processes are championed by the jewelers that carry our products.</p>

		<p>But most importantly, our jewelry is beloved by people just like you.</p>
	</div>

	<?php if($_SESSION['id']){ 
		$conObj = new regodesign\users\Consumers;
		$logged = $conObj->readConsumerByID($_SESSION['id']); ?>
		<div class="c50">
			<h2>Welcome back, <?=$logged->getFullName(); ?></h2>
		</div>
	<?php } else { ?>
		<div class="c50">
			<p>If this is your first time using our new site and you have an account from our old site, you may login using your email address and the same password that you used on the old site.</p>

			<p class="error"><?=$message; ?></p>

			<form action="" id="dealer-login" method="POST">
				<label for="username">Username</label>
				<input type="text" name="username" id="username" required>
				
				<label for="password">Password</label>
				<input type="password" name="password" required>

				<input type="submit" name="submit" value="Login">
			</form>
			<a href="forgot_password.php">Forgot Your Password?</a>
		</div>
	<?php } ?>
	
</div>
<script>
    $('#username').focus();
</script>

<?php include('includes/footer.php'); ?>