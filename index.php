<?php

if (!isset($_SESSION)) {
    session_start();
}
//session_destroy();
include 'util/top.php';
$not_logged_in="";
if (!empty($_SESSION['player'])) {
    $print = '';
} else {
    if (isset($_GET['not_logged_in'])) {
        $not_logged_in = "<h1>".ERROR_NOT_LOGGED_IN."</h1>";
    }
    $print = $not_logged_in.$_SERVER['SERVER_ADDR'];
}
echo $print;
include 'util/bottom.php';
?>