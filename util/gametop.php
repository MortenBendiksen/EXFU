<?php
include_once 'language.php';
if (!isset($_SESSION)) {
    session_start();
}
$script = '';
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
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="/css/game.css" rel="stylesheet" />
        <script src="/js/jquery-3.1.0.min.js" type="text/javascript"></script>
        <script src="/js/jquery.transit.min.js" type="text/javascript"></script>
        <script src="/js/game.js" type="text/javascript"></script>
        <?php if (isset($PAGE_BATTLE)) {
            echo '<script src="/js/battle.js" type="text/javascript"></script>';
        } ?>
<?php echo $script; ?>
    </head>
    <body id="battle">
        <div id="overlay"></div>
        <header>
            <h1><?php echo GAME_NAME; ?></h1>
            <a href="." id="banner">
                <img src="../css/images/banner.png" width="150" height="50" />
            </a>
            <menu>
                <div id="menu_btn"><?php echo SETTING_BTN; ?></div>
                <a href="/"><?php echo MENU_HOME_SYMBOL . " " . MENU_HOME ?></a>
                <?php
                if (isset($PAGE_BATTLE)) {
                    echo "<pointerAction start='$pointerAction'></pointerAction><span id='skip'>" . MENU_BATTLE_SKIP_ANIMATION . "</span>";
                }else{
                    echo "<a id='map_btn' href='#'>".MENU_MAP."</a>";
                }
                ?>
                <div id="menu_logout">
                    <a  id="logout_confirm" href="/util/logout.php"><?php echo LOGOUT_TEXT; ?>?</a>
                    <a id="logout_btn" href="#"><?php echo SETTING_LOGOUT ?></a>
                    <a id="menu_light"><?php echo SETTING_LIGHT ?></a>
                </div>
<?php if (isset($PAGE_BATTLE)) {
    echo "<turns></turns>";
} ?>
            </menu>
            <div class="c"></div>
        </header>
        <div id="content">
            <div id="map"></div>