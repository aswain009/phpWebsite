<?php
ini_set('session.cookie_lifetime', 31536000);
ini_set('error_reporting', E_ALL);
session_start();

//Common URLS for client side includes
//
define('ROOT_URL', '/beta/');
define('MANAGE_URL', ROOT_URL . 'manage/');
define('ASSET_URL', MANAGE_URL . 'assets/');
define('BOWER_URL', MANAGE_URL . 'assets/bower_components/');
define('JS_URL', MANAGE_URL . 'assets/js/');
define('CSS_URL', MANAGE_URL . 'assets/css/');
define('LIB_URL', MANAGE_URL . 'assets/lib/');

//Common folders on the server for server side includes. 
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/beta/');
define('INCLUDE_DIR', DOCUMENT_ROOT . 'manage/includes/');
define('CLASS_DIR', DOCUMENT_ROOT . 'classes/');

//Manage Names
define('SITE_NAME', 'Rego Designs');

//Upload Paths
define('LOGO_PATH', DOCUMENT_ROOT.'images/logos/');
define('LOGO_URL', ROOT_URL.'images/logos/');
define('PRODUCT_IMAGE_PATH', DOCUMENT_ROOT.'images/products/');
define('PRODUCT_IMAGE_URL', 'http://regodesigns.com'.ROOT_URL.'images/products/');

define('FROALA_ACTIVATION_KEY', 'jbA1vkblf1kE4obc==');

//Autoloader
require_once(DOCUMENT_ROOT . 'autoloader.php');