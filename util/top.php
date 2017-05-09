<?php
include_once 'util/language.php';
if (!isset($_SESSION)) {
    session_start();
}
$head = "";
$script = "";
$menu_login = "";
if (isset($_SESSION['player'])) {
    include_once 'model/Player.php';
    $player = unserialize($_SESSION['player']);
    $menu_login.= "<a href='user.php?id={$player->getIntId()}'>{$player->getStrDisplayName()}</a>\n<a href='util/logout.php'>".LOGOUT_TEXT."</a>";
    $head = '<meta http-equiv="refresh" content="1200;URL=/util/logout.php?a=1">';
} else {
    $menu_login = "<a href='login.php'>".LOGIN_TEXT."</a>\n<a href='signup.php'>".SIGN_UP_TEXT."</a>";
}
if (isset($PAGE_LOGIN) && $PAGE_LOGIN) {
    $script = '<script src="js/login.js" type="text/javascript"></script>';
}
if (isset($PAGE_SIGNUP) && $PAGE_SIGNUP) {
    $script = '<script src="js/signup.js" type="text/javascript"></script>';
}
if (isset($_SESSION['light']) && $_SESSION['light'] == 0) {
    $script.="\n<script>\n"
            . "$('document').ready(function () {\n"
            . "\t$('#overlay').css('opacity',.8);\n"
            . "\t$('#footerbottom').css('background-color','#000');\n"
            . "\t$('#menu_light').css('color','#000');\n"
            . "});\n"
            . "\n</script>\n";
}
?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo GAME_NAME; ?></title>
        <?php echo $head; ?>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/site.css" rel="stylesheet" />
        <script src="js/jquery-3.1.0.min.js" type="text/javascript"></script>
        <script src="js/jquery.transit.min.js" type="text/javascript"></script>
        <script src="js/site.js" type="text/javascript"></script>
        <?php echo $script; ?>
    </head>
    <body id="site">
        <div id="overlay"></div>
        <header><h1><?php echo GAME_NAME; ?></h1><a href="."><img src="css/images/banner.png" width="150" height="50" /></a></header>
        <menu>
            <div id="menu_btn"><?php echo SETTING_BTN; ?></div>
            <a href="#" id="start"><?php echo MENU_START_GAME; ?></a>
            <a id="test"></a>
            <div id="menu_login">
                <?php echo $menu_login; ?>
                <a id="menu_light"><?php echo SETTING_LIGHT ?></a>
            </div>
            <div class="c"></div>
        </menu>
        <div id="content">