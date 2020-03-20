<?php
use regodesign\users\Retailers;
use regodesign\users\Consumers;
use a3smedia\utilities\Database;

function isHome() {
    if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false || strpos($_SERVER['REQUEST_URI'], '.php') === false) {
        return true;
    }
    return false;
}

if (strpos($_SERVER['REQUEST_URI'], 'dealer.php') === false) {
    // unset($_SESSION['admin']);
}

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

//$host = $_SERVER['HTTP_HOST'];
//get url
$url = $_SERVER['HTTP_HOST'];
$hostParts = parse_url($url);
$host = $hostParts['path'];

//split url
$host_names = explode(".", $host);

//remove unwanted peices
$bottom_host_name = $host_names[count($host_names)-2] . "." . $host_names[count($host_names)-1];

echo "<!-- $bottom_host_name -->";

if ($host !== 'www.regodesigns.com') {
    $retailer = \regodesign\users\Retailers::readByDomain($bottom_host_name);
    if ($retailer) {
        $guest = createGuest($retailer);
        $_SESSION['id'] = $guest->getID();
        $_SESSION['type'] = 2;
        $_SESSION['logo'] = $retailer->getLogo();
        $_SESSION['title'] = $retailer->getName();

        if (!$_SESSION['autologin']) {
            $_SESSION['autologin'] = true;
            if (!empty($retailer->getBanner())) {
                header('Location: /beta');
            } else {
                header('Location: /beta/store.php?cat=bridal');
            }
        }
    }
}

$affiliate = filter_input(INPUT_GET, 'affil');
if ($affiliate) {
    $retailer = \regodesign\users\Retailers::readRetailerByID($affiliate);
    if ($retailer) {
        $guest = createGuest($retailer);
        $_SESSION['id'] = $guest->getID();
        $_SESSION['type'] = 2;
        $_SESSION['autologin'] = true;
        $_SESSION['logo'] = $retailer->getLogo();

        if (!empty($retailer->getBanner())) {
            header('Location: /beta');
        } else {
            header('Location: /beta/store.php?cat=bridal');
        }
    }
}

if (isset($_SESSION['id'])) {
    $consumer = Consumers::readConsumerByID($_SESSION['id']);
    $retailer = Retailers::readRetailerByID($consumer->getRetailerID());
}

$db = \a3smedia\utilities\Database::PDO();
$query = $db->prepare("SELECT * FROM `categories` WHERE `visible` = 1 ORDER BY `order`");
$query->execute();
$categories = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php if(isset($_SESSION['title'])) {
        echo '<title>', $_SESSION['title'], '</title>', PHP_EOL;
    } else {
        echo '<title>Rego Designs</title>';
    }
    ?>
    <link rel="stylesheet" type="text/css" href="css/magiczoom.css">
    <link rel="stylesheet" type="text/css" href="css/chosen.min.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css/?primary=<?php if($_SESSION['type'] == 2 && $retailer->getColor() !== '') echo $retailer->getColor(); else echo '5BC0E6'; ?>">
    <?php if (isHome()): ?><link rel="stylesheet" type="text/css" href="css/index.css"><?php endif; ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/chosen.jquery.min.js"></script>
    <script src="js/magiczoom.js"></script>
    <style type="text/css">
        /*
            SCROLL TO TOP
        */
        
        .scroll-top-wrapper {
            position: fixed;
            opacity: 0;
            visibility: hidden;
            overflow: hidden;
            text-align: center;
            z-index: 99999999;
            background-color: #5BC1E7;
            color: #FCFCFC;
            width: 50px;
            height: 48px;
            line-height: 48px;
            right: 30px;
            bottom: 30px;
            padding-top: 2px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -ms-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .scroll-top-wrapper:hover {
            background-color: #343434;
        }
        .scroll-top-wrapper.show {
            visibility:visible;
            cursor:pointer;
            opacity: 1.0;
        }
        .scroll-top-wrapper i.fa {
            line-height: inherit;
        }
        #nav-links {
            text-transform: uppercase;
        }
    </style>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        addEventListeners();
    });
    function addEventListeners() {
        var MAX_HEIGHT = 400;
        $('.scroll-top-wrapper').on('click', scrollToTop);
        $(document).on('scroll', function(event) {
            if( $(document).scrollTop() >= MAX_HEIGHT )
                $('.scroll-top-wrapper').addClass('show');
            else
                $('.scroll-top-wrapper').removeClass('show');
        });
        function scrollToTop() {
            var verticalOffset = typeof(verticalOffset) != 'undefined' ? verticalOffset : 0;
            var element = $('body');
            var offset = element.offset();
            var offsetTop = offset.top;
            $('html, body').animate({scrollTop: offsetTop}, 500, 'linear');
        }
    }
    </script>
</head>
<body>
<div id="wrapper">
    <div class="row" id="header-links">
        <div>
            <?php if ($_SESSION['type'] != 2) { ?>
                <a href="about.php">About Us</a>
            <?php }
            if (isset($_SESSION['id']) && $_SESSION['id']) {
                if ($_SESSION['type'] != 2) {
                    echo '<a href="merchandise.php">Merchandising</a>';
                    echo '<a href="creative.php">Rego Creative</a>';
                    echo '<a href="dealer.php">Dealer Preferences</a>';
                    echo '<a href="orders.php">Order History</a>';
                    echo '<a href="contact-us.php">Contact Us</a>';
                }
                if (!$_SESSION['autologin']) echo '<a href="logout.php"><strong>Logout</strong></a>';
            } else {
                echo '<a href="dealer-locator.php">Dealer Locator</a>';
                echo '<a href="login.php"><strong>Dealer Login</strong></a>';
            } ?>
        </div>
    </div> <!-- row -->
    <div id="nav">
        <?php
        $type = $_SESSION['type'];
        if (($type == 2 || basename($_SERVER['PHP_SELF']) == 'dealer.php')): ?>
            <div id="logo">
                <?php if (!empty($banner)): ?>
                    <a href="index.php">
                <?php else: ?>
                    <a href="#">
                <?php endif; ?>
                <?php if (!empty($retailer->getLogo())): ?>
                    <img src="images/logos/<?php echo $retailer->getLogo(); ?>"></a>
                <?php else: ?>
                    <img src="images/logo.jpg"></a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div id="logo">
                <a href="index.php"><img src="images/logo.jpg"></a>
            </div>
        <?php endif; ?>
        
        <?php if(isHome()): ?>
        <div id="search" style="float: left;"><form action="search.php" method="GET">
            <input type="text" id="search-text" name="q"><input type="submit" value="SEARCH">
            <input type="hidden" name="search-category[]" value="all">
            </form></div>
        <?php endif; ?>
        <div id="nav-links">
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li><a href="store.php?cat=<?= $category['slug'] ?>"><?= $category['name'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div> <!-- nav-links -->
        
    </div> <!-- #nav row -->
    <!-- scroll to top -->
    <div class="scroll-top-wrapper" style="">
        <span class="scroll-top-inner">
            <i class="fa fa-2x fa-arrow-circle-up"></i>
        </span>
    </div>