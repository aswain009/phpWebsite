<?php require('manage/includes/settings.php');

use a3smedia\utilities\Database;
use regodesign\users\Retailers;
use regodesign\users\Consumers;

$consumer = Consumers::readConsumerByID($_SESSION['id']);

if (!function_exists('createGuest')) {
    function createGuest($retailer)
    {
        $db = Database::PDO();
        $query = $db->prepare('SELECT * FROM consumers WHERE retailerId = ? AND type = 2');
        $query->execute([$retailer->getID()]);
        $row = $query->fetch();

        if (!isset($row['username'])) {
            $guest_base = filter_var($retailer->getName(), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            $guest_base = preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($guest_base));
            $guest_email = $guest_base.'_guest';
        } else {
            $guest_email = $row['username'];
        }

        $guest = Consumers::readConsumerByUsername($guest_email);
        if (!$guest) {
            $guest = new Consumers();
            $temp_pass = $guest_base;
            $db_hash = sha1($temp_pass);

            $guest->setRetailerID($retailer->getID());
            $guest->setType(2);
            $guest->setUsername($guest_email);
            $guest->setPassword($db_hash);
            $guest->setFullName('');
            $guest->setAddressStreet('');
            $guest->setAddressSuite('');
            $guest->setAddressCity('');
            $guest->setAddressState('');
            $guest->setAddressZip('');
            $guest->setPhone('');

            $guest->createConsumer();
        }

        return $guest;
    }
}

if (!$_SESSION['autologin']) {
    $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
} else {
    $retailer = Retailers::readRetailerByID($_SESSION['id']);
}

function processConsumer($post)
{
    $email = $post['consumerEmail'];
    if ($email) {
        $consumer = Consumers::readConsumerByUsername($email);
        if ($consumer) {
            if ($post['password'] === $post['confirm_password']) {
                $db_hash = sha1($post['password']);
                $consumer->setPassword($db_hash);
                $consumer->updateConsumer();
            }
            if ($post['consumerEmail'] !== $post['email']) {
                $consumer->setUsername($post['email']);
                $consumer->updateConsumer();
            }
        }
    }
}

function loginAdmin($post)
{
    $user = Consumers::readConsumerByID($_SESSION['id']);
    if ($user->getAdminPassword() === sha1($post['adminPassword'])) {
        $_SESSION['admin'] = true;
        $user->acceptDisclaimer();
        $user->updateConsumer();
    }
}

function resetDealerDisplay($post, $retailer)
{
    $retailer->setLogo(NULL);
    $retailer->setColor(NULL);
    $retailer->updateRetailer();
}

function processDealerDisplay($post, $retailer)
{
    if (isset($_FILES['home-image'])) {
        
        //thanks php.net
        try {

            if (
                !isset($_FILES['home-image']['error']) ||
                is_array($_FILES['home-image']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }

            switch ($_FILES['home-image']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            if ($_FILES['home-image']['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            if (!move_uploaded_file(
                $_FILES['home-image']['tmp_name'],
                sprintf('./images/banners/%s.png', $retailer->getId())
            )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            $retailer->setBanner($retailer->getId() . '.png');
            echo 'File is uploaded successfully.';
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }

    if (isset($_FILES['logo-image'])) {
        
        //thanks php.net
        try {

            if (
                !isset($_FILES['logo-image']['error']) ||
                is_array($_FILES['logo-image']['error'])
            ) {
                throw new RuntimeException('Invalid parameters.');
            }

            switch ($_FILES['logo-image']['error']) {
                case UPLOAD_ERR_OK:
                    break;
                case UPLOAD_ERR_NO_FILE:
                    throw new RuntimeException('No file sent.');
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    throw new RuntimeException('Exceeded filesize limit.');
                default:
                    throw new RuntimeException('Unknown errors.');
            }

            if ($_FILES['logo-image']['size'] > 1000000) {
                throw new RuntimeException('Exceeded filesize limit.');
            }

            if (!move_uploaded_file(
                $_FILES['logo-image']['tmp_name'],
                sprintf('./images/logos/%s.png', $retailer->getId())
            )) {
                throw new RuntimeException('Failed to move uploaded file.');
            }

            $retailer->setLogo($retailer->getId() . '.png');
            echo 'File is uploaded successfully.';
        } catch (RuntimeException $e) {
            echo $e->getMessage();
        }
    }

    if (isset($post['primary-color']) && $post['primary-color'] !== '#000000') {
        $retailer->setColor(substr($post['primary-color'], 1));
    }
    $retailer->setMarkup($post['price-markup']);
    $retailer->updateRetailer();
}

if (isset($_POST['submit'])) {
    createGuest($retailer);
    processConsumer($_POST);
    $message = 'Guest password has been updated!';
}
if (isset($_POST['adminSubmit'])) {
    loginAdmin($_POST);
}
if (isset($_POST['dealerDisplay'])) {
    processDealerDisplay($_POST, $retailer);
    createGuest($retailer);
}
if (isset($_POST['dealerDisplayReset'])) {
    resetDealerDisplay($_POST, $retailer);
    createGuest($retailer);
}
if (isset($_POST['updateSubmit'])) {
    if ($_POST['updatePassword'] === $_POST['confirmPassword']) {
        $consumer->setAdminPassword(sha1($_POST['updatePassword']));
        $consumer->updateConsumer();
    }
}

$db = Database::PDO();
$query = $db->prepare('SELECT * FROM consumers WHERE retailerId = ? AND type = 2');
$query->execute([$retailer->getID()]);
$row = $query->fetch();

if (!isset($row['username'])) {
    $guest_base = filter_var($retailer->getName(), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    $guest_base = preg_replace('/[^A-Za-z0-9\-]/', '', strtolower($guest_base));
    $guest_email = $guest_base.'_guest';
} else {
    $guest_email = $row['username'];
}


include('includes/header.php');
?>

<h3>DEALER ACCOUNT</h3>

<div class="row">
    <div id="dealerBody" class="row">
        <?php if (!isset($_SESSION['admin'])): ?>
            <p>Please contact Rose at 1-800-537-4932 or rose@regoonline.com to create a temporary Administrative password that will allow you to personalize the appearance of your Guest Login pages by adding a store logo image, setting the accent color of the page to your store colors or to match your website, and to set a retail price mark-up.</p>
            
                <?php if (!$consumer->acceptedDisclaimer()): ?><font size=-1>
                    <center><textarea style="width: 90%; height: 18em;">
                        Retailer acknowledges and agrees that they will not submit any user content that may be considered defamatory, harassing, abusive, harmful to minors or any protected class, pornographic, "X-rated" , obscene or otherwise objectionable. 

                        Retailer specifically acknowledges and agrees that their use of the Website and the Services found at the Website shall be at their own risk and that the Website and  Services are provided "as is", "as available" and "with all faults”.  Rego Manufacturing Company, Inc.  its officers, directors, employees and agents disclaim all warranties, statutory, express or implied. Including but not limited to, any implied warranties of title, merchantability, fitness for a particular purpose and non- infringement. Rego Manufacturing Company, Inc., its officers, directors, employees and agents make no representations or warranties about (1) the accuracy, completeness, or content of Website, (2) the Services found at this site. And assumes no liability for the same.

                        The foregoing disclaimer of representations and warranties shall apply to the fullest extent permitted by law.

                        In no event shall Rego Manufacturing Company, Inc., its officers, directors, employees or agents, be liable to you any other person or entity for any direct, indirect, incidental, special, punitive, or consequential damages whatsoever, including any that may result from (1) the accuracy, completeness, or content of the Website,  (2) the Services provided by Rego Manufacturing Company, Inc. , (3) personal injury or property damage of any nature whatsoever,  (4) third-party conduct of any nature whatsoever, (5) any unauthorized access to or use of our servers and/or any and all content, personal information, financial information or other information and data stored therein, (6) any interruption or cessation of services to or from the Website, (7) any viruses, worms, bugs, Trojan horses, or the like, which may be transmitted to or from the website, (8) any user content or content that is defamatory, harassing, abusive, harmful to minors or any protected class, pornographic, "X-rated" , obscene or otherwise objectionable , and/or (9) any loss or damage of any kind incurred as a result of your use of the Website or Services, whether based on warranty, contract, tort, or any other legal or equitable theory, and whether or not Rego Manufacturing Company, Inc. is advised of the possibility of such damages.

                        The foregoing limitation of liability shall apply to the fullest extent permitted by law. 
                    </textarea></font></center>
                    <script>
                        $(document).on('ready', function() {
                            $('#adminForm').on('submit', function(e) {
                                if (!$('#disclaimer').is(':checked')) {
                                    e.preventDefault();
                                }
                            });
                        });
                    </script>
                <?php endif; ?>
                <form action="" method="POST" id="adminForm">
                    <?php if (!$consumer->acceptedDisclaimer()): ?>
                        <div style="margin: 20px 0"><input id="disclaimer" type="checkbox">&nbsp;&nbsp;&nbsp;&nbsp;I have read and agree to the Terms of Service.</div>
                    <?php endif; ?>
                    <div class="formInput">
                        <label>Adminstrator password</label>
                        <input type="password" name="adminPassword" id="adminPassword">
                    </div>
                    <input type="submit" name="adminSubmit" value="Log In">
                </form>
                <script>
                    $('#adminPassword').focus();
                </script>
        <?php else: ?>
            <?php if ($consumer->canUpdateAdminPassword()): ?>
                <h2>Please update your password.</h2>
                <form action="" method="POST" id="adminUpdate">
                    <div class="formInput">
                        <label for="password">Password</label>
                        <input type="password" name="updatePassword">
                    </div>
                    <div class="formInput">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" name="confirmPassword">
                    </div>
                    <input type="submit" name="updateSubmit" value="Update">
                </form>
            <?php else: ?>
                <div id="guest">
                    <h3>Rego will not be held responsible for the content of your Guest Login</h3>
                    <h4>For your security you will be logged out as Administrator when you leave the Dealer Preferences Page.</h4>
                    <span style="margin-left: 10%; color:#555"><?= $message ?></span>
                    <p>Create a guest login:</p>        
                    <form id="consumerForm" action="" method="POST">
                        <input type="hidden" name="consumerEmail" id="consumerEmail" value="<?php echo $guest_email; ?>" readonly />
                        <div class="formInput">
                            <label for="email">Username</label>
                            <input type="text" name="email" id="email" value="<?php echo $guest_email; ?>" />
                        </div>
                        <div class="formInput">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" placeholder="*******" />
                        </div>
                        <div id="confirm_password_div" style="display: none">
                            <div class="formInput">
                                <label for="confirm_password">Confirm password</label>
                                <input type="text" name="confirm_password" id="confirm_password" />
                            </div>
                            <div class="formInput submit">
                                <input type="submit" name="submit" id="submit" value="Change Password" />
                            </div>
                        </div>
                    </form><!--#consumerForm-->
                    <script>
                        $('#password').on('focus', function() {
                            $('#confirm_password_div').show(250);
                        });
                    </script>
                </div><!--#guest-->
                <hr><br>
                <div id="administration">
                    <font size=-1>
                    <center><textarea id="terms" style="width: 90%; height: 18em; display:none;">
                        Retailer acknowledges and agrees that they will not submit any user content that may be considered defamatory, harassing, abusive, harmful to minors or any protected class, pornographic, "X-rated" , obscene or otherwise objectionable. 

                        Retailer specifically acknowledges and agrees that their use of the Website and the Services found at the Website shall be at their own risk and that the Website and  Services are provided "as is", "as available" and "with all faults”.  Rego Manufacturing Company, Inc.  its officers, directors, employees and agents disclaim all warranties, statutory, express or implied. Including but not limited to, any implied warranties of title, merchantability, fitness for a particular purpose and non- infringement. Rego Manufacturing Company, Inc., its officers, directors, employees and agents make no representations or warranties about (1) the accuracy, completeness, or content of Website, (2) the Services found at this site. And assumes no liability for the same.

                        The foregoing disclaimer of representations and warranties shall apply to the fullest extent permitted by law.

                        In no event shall Rego Manufacturing Company, Inc., its officers, directors, employees or agents, be liable to you any other person or entity for any direct, indirect, incidental, special, punitive, or consequential damages whatsoever, including any that may result from (1) the accuracy, completeness, or content of the Website,  (2) the Services provided by Rego Manufacturing Company, Inc. , (3) personal injury or property damage of any nature whatsoever,  (4) third-party conduct of any nature whatsoever, (5) any unauthorized access to or use of our servers and/or any and all content, personal information, financial information or other information and data stored therein, (6) any interruption or cessation of services to or from the Website, (7) any viruses, worms, bugs, Trojan horses, or the like, which may be transmitted to or from the website, (8) any user content or content that is defamatory, harassing, abusive, harmful to minors or any protected class, pornographic, "X-rated" , obscene or otherwise objectionable , and/or (9) any loss or damage of any kind incurred as a result of your use of the Website or Services, whether based on warranty, contract, tort, or any other legal or equitable theory, and whether or not Rego Manufacturing Company, Inc. is advised of the possibility of such damages.

                        The foregoing limitation of liability shall apply to the fullest extent permitted by law. 
                    </textarea></font></center>
                    <a href="#" id="showTerms">View Terms of Service Agreement</a>
                    <script>
                        $(function () {
                            $('#showTerms').on('click', function() {
                                $('#terms').show(250);
                            });
                        });
                    </script>
                    <div class="c50">
                        <form method="POST" action="" id="dealerForm" enctype="multipart/form-data">
                            <div class="formInput">
                                <label for="logo-image">Logo Image</label>
                                <input type="file" name="logo-image" id="logo-image" accept="image/*"><i>Recommended: 220px × 125px</i>
                            </div>
                            <div class="formInput">
                                <label for="primary-color">Primary Color</label>
                                <input type="color" name="primary-color" id="primary-color" value="#<?= $retailer->getColor() ?>">
                            </div>
                            <div class="formInput">
                                <label for="price-markup">Price Markup</label>
                                <input type="number" min="1.5" max="4.0" step=".01" name="price-markup" id="price-markup" value="<?= ($retailer->getMarkup() !== '0.00') ? $retailer->getMarkup() : '3.00' ?>" style="width:3.5em"><i>(markup from Jewelers Cost)</i>
                            </div>
                            <div class="formInput submit">
                                <input class="button" name="dealerDisplay" type="submit" value="Save Changes">
                                <input class="button" name="dealerDisplayReset" type="submit" value="Reset">
                            </div>
                        </form><!--#dealerForm-->
                    </div>
                    <div class="c50">
                        <p>Click the Browse button and locate the Logo image to upload for your Guest Login. Either .JPG or .PNG files will work.</p>
                        <p>Click in the Color box and choose an accent color for your Guest Login that matches your website or store colors. Click OK in the Color Box when you are satisfied with your color selection.</p>
                        <p>To set the Retail Markup for your Guest Login enter the number to multiply the jewelers cost by in the Retail Mark-up box. For example an item with a jewelers cost of $100 would be displayed as $250 on the Guest Login if you entered 2.5 in the Mark Up box.</p>
                        <p>To Revert to the Rego Logo and black accent color and default Mark Up click on the Reset Button.</p>
                        <p>To save your changes click the Save Changes Button before leaving this page.</p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div><!--#dealerBody-->
</div>

<?php include('includes/footer.php'); ?>
