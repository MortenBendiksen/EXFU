<?php
$PAGE_LOGIN = true;
include 'util/top.php';
if(isset($_SESSION['player'])){
    $print = "Log ud";
}else{
    include_once 'util/formular.php';
    $formular = new Formular();
    $print = '<div id="login">'
            . $formular->text("email","email", SIGN_UP_EMAIL.":")
            .'<div class="c"></div>'
            . $formular->password("password","password", SIGN_UP_PASSWORD.":")
            .'<div class="c"></div>'
            .'<table id="antikeylog">
            <tr id="klu"><td><button n="1">&#9650;</button></td> <td><button n="2">&#9650;</button></td>  <td><button n="3">&#9650;</button></td></tr>
            <tr id="kln"><td n="1">0</td>       <td n="2">0</td>        <td n="3">0</td></tr>
            <tr id="kld"><td><button n="1">&#9660;</button></td> <td><button n="2">&#9660;</button></td>  <td><button n="3">&#9660;</button></td></tr>
        </table>'
            .'<div class="c"></div>'
            . $formular->button("login_btn",LOGIN_TEXT)
            . '</div>';
}
echo $print;
include 'util/bottom.php';
?>