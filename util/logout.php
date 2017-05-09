<?php

include_once 'Db.php';
include_once '../model/Player.php';
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['player'])) {
    $DB = new DB();
    echo $DB->logout(unserialize($_SESSION['player']));
    session_destroy();
}
if (isset($_GET['a']) && $_GET['a'] == 1) {
    header("Location: /logout.php");
} else {
    header("Location: /.");
}
die();
?>
