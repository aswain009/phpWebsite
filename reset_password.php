<?php
session_start();
session_destroy();
require('manage/includes/settings.php');

use \a3smedia\utilities\Database;


$reset_id = filter_input(INPUT_GET, 'id');

if ($reset_id) {
    $consumer = Database::read('\regodesign\users\Consumers', $reset_id, 'consumerRecovery', 'consumers');
}

$password = filter_input(INPUT_POST, 'password');
$confirm_password = filter_input(INPUT_POST, 'confirm_password');

if ($password && $confirm_password) {
    if ($password == $confirm_password) {
        $db = Database::PDO();
        $db->beginTransaction();

        $pass_gen = sha1($password);
        $query = $db->prepare('UPDATE consumers SET consumerPassword = :hash, consumerRecovery = "" WHERE consumerID = :consumerID');
        $query->bindValue(':hash', md5($password));
        $query->bindValue(':consumerID', $consumer->getID(), \PDO::PARAM_INT);
        $query->execute();

        $db->commit();
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
      <?php
        if ($consumer) { ?>
        <form id="contact-form" action="" method="POST">
            <label for="password">New Password:</label><input type="password" name="password" required><br>
            <label for="confirm_password">Confirm New Password:</label><input type="password" name="confirm_password" required><br>
            <input type="submit" value="Submit">
        </form>
        <?php } else {
            echo 'Invalid password URI';
        }
        ?>
    </div> <!-- #content -->
  </div> <!-- row -->

<?php include('includes/footer.php'); ?>