<?php
    session_start();
    $type = $_SESSION['type'];
    session_destroy();
    
    if ($type !== 2) {
        header('Location: login.php');
    } else {
        header('Location: https://google.com');
    }
?>