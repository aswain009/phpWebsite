<?php
session_start();
session_destroy();
require('manage/includes/settings.php');

use \a3smedia\utilities\Database;

$email = filter_input(INPUT_POST, 'email');

if ($email) {
    $consumer = \regodesign\users\Consumers::readConsumerByUsername($email);
    if ($consumer) {
        $recovery = bin2hex(openssl_random_pseudo_bytes(24));
        $db = Database::PDO();
        $query = $db->prepare('UPDATE consumers SET consumerRecovery=:recovery WHERE consumerUsername=:email');
        try {
            $query->execute(array(
                ":recovery" => $recovery,
                ":email" => $email
            ));
        } catch (PDOException $e) {
            return 'Could not create recovery address.';
        }

        $email_body = "Please visit <a href=\"http://a3smedia.com/rego-frontend/reset_password.php?id=$recovery\">this link</a> to reset your password!";
        mail($email, 'Rego Designs Password Reset', $email_body, "Content-Type: text/html; charset=ISO-8859-1\r\n");
        header('Location: login.php');
    }
}

include('includes/header.php'); ?>

<div class="row">
    <div id="search" style="float: left">
      <form action="search.php" method="GET">
      <input type="text" id="search-text" name="q"><input type="submit" value="SEARCH">
      </form>

      <div class="clear"></div>

    </div>  
    <h3 id="store-category" style="float: left; margin-left: 30px">Reset Password</h3>

  </div> <!-- row -->

  <div class="row">
    <div id="content">
        <form id="contact-form" action="" method="POST">
            <label for="email">Email Address:</label><input type="email" name="email" required><br>
            <input type="submit" value="Submit">
        </form>
    </div> <!-- #content -->
  </div> <!-- row -->

<?php include('includes/footer.php'); ?>