<?php 
require_once('includes/settings.php');
include('includes/header.php'); 

$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $zip = $_POST['zip'];
    $comments = $_POST['comments'];
// Get the client ip address
    $ipaddress = $_SERVER['REMOTE_ADDR'];

    $string = $comments;
    $regex = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $commentsClean = preg_replace($regex, "", $string);

    //var_dump($commentsClean);
    //die();

    $fullName = $firstName . ' ' . $lastName;

    $headers = 'From: info@regoonline.com' . "\r\n" .
        'Bcc: dwhite@regoonline.com';

//    $message = "$fullName <$email> is looking for dealers near $zip.\r\n" . $commentsClean . "\r\n";
      $message = "$fullName <$email> is looking for dealers near $zip.\r\n\r\n" . $commentsClean . "\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n Sent From IP: $ipaddress" . "\r\n";
    mail('ken@regoonline.com', 'Dealer Locator', $message, $headers);

    $sent = true;
}
?>

<div class="row">
  <div id="search" style="float: left">
      <form action="search.php" method="GET">
        <input type="text" id="search-text" name="q"><input type="submit" value="SEARCH">
      </form>
    </div>    
  <h3 style="float: left; margin-left: 30px">DEALER LOCATOR</h3>
</div>

<div class="row">
  <div id="content">
    <div class="c40">
      <p>Fill out the form to find a Rego dealer near you:</p>
      <img src="images/gold-logo.jpg">
    </div>
    <div class="c60">
      <form action="" id="contact-form" method="POST">
        <div class="form-group">
          <label for="firstName">First Name</label>
          <input type="text" name="firstName" required>
        </div><!--.form-group-->

        <div class="form-group">
          <label for="lastName">Last Name</label>
          <input type="text" name="lastName" required>
        </div><!--.form-group-->

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="text" name="email" required>
        </div><!--.form-group-->

        <div class="form-group">
          <label for="zip">Zip Code</label>
          <input type="text" name="zip" required>
        </div><!--.form-group-->

        <div class="form-group">
          <label for="comments">Comments</label>
          <textarea name="comments" id="comments" cols="30" rows="10"></textarea>
        </div><!--.form-group-->
        <input type="submit" value="Submit">
        <?php if ($sent): ?>
            <div>
                <div style="width: 130px; display: inline-block">&nbsp;</div>
                <span>Message sent!</span>
            </div>
        <?php endif; ?>
      </form>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
