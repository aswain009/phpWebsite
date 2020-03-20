<?php session_start();

//Common folders on the server for server side includes.
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'] . '/beta/');

//Autoloader.
require_once(DOCUMENT_ROOT . 'autoloader.php');