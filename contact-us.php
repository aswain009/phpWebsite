<?php
if($_POST['contactSubmit']){
    $message = processDealerAccount($_POST);
}
require_once('includes/settings.php');
include('includes/header.php'); ?>

<h3>CONTACT US</h3>
<h2>We'd love to hear from you!</h2>

<div class="row">
    <div class="c10">&nbsp;</div>
    <div class="c50">
        <div class="row">
            <address>
                Rego Designs<br>
                1870 E. Mansfield St.<br>
                Bucyrus, OH 44820
            </address>
        </div>
        <div class="row">
            <div class="c50">
                <div style="float: left; padding-right: 10px;">Phone:</div>
                <div style="float: left"><a href="tel:4195620466">419-562-0466</a><br>
                <a href="tel:8005374932">800-537-4932</a></div>
            </div>
            <div class="c50">
                <div style="float: left; padding-right: 10px;">Email:<br>Fax:</div>
                <div style="float: left"><a href="mailto:rego@regoonline.com">rego@regoonline.com</a><br>
                <a href="#">419-562-5059</a></div>
            </div>
        </div>
        <div class="row">
            <br>
            <form action='' method='POST'>
                <div class="formInput">
                    <label for="name">Your name</label>
                    <input type="text" name="name" id="name">
                </div>
                <div class="formInput">
                    <label for "store">Store name</label>
                    <input type="text" name="store" id="store">
                </div>
                <div class="formInput">
                    <label for "email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="formInput">
                    <label for "phone">Phone</label>
                    <input type="tel" name="phone" id="phone">
                </div>
                <div class="formInput textarea">
                    <label for="message">Message</label>
                    <textarea name="message" id="message"></textarea>
                </div>
                <div class="formInput submit">
                    <input class="button" name="contactSubmit" id="contactSubmit" type="submit" value="Send">
                </div>
                <div class="formInput">
                    <p><?php echo $message; ?></p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
<?php
function processDealerAccount($post){
    $to = 'sales@regoonline.com';

    $subject = 'Contact Us';
    $headers  = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
    $headers .= 'From: '.$post['store'].' <'.$post['email'].'>';

    $body  = '<h1>Rego Contact Request</h1>';
    $body .= '<h3>'.$post['name'].'</h3>';
    $body .= '<h3>'.$post['store'].'</h3>';
    $body .= '<h3>'.$post['phone'].'</h3>';
    $body .= '<h3>'.$post['email'].'</h3>';
    $body .= '<p>'.$post['message'].'</p>';

    if(mail($to, $subject, $body, $headers)){
        return 'Request sent';
    } else {
        return 'Request unable to be sent';
    }
}
