<?php

if (isset($_SESSION['player'])) {
    include_once $_SERVER['DOCUMENT_ROOT'].'/model/Player.php';
    $player = unserialize($_SESSION['player']);
    $lang = $player->getStrLanguage();
} else {
    $lang = "en";
}
include_once "language/symbols.php";
include_once "language/$lang.php";

include_once "language/catcherrors.php";
