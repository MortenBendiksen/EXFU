<?php
$PAGE_SIGNUP = true;
include 'util/top.php';
include_once 'util/formular.php';
$formular = new Formular();
$print = '<div id="signup">';
$print.=$formular->text("name", "name", strtolower(SIGN_UP_DISPLAY_NAME), SIGN_UP_DISPLAY_NAME, 1);
$print.=$formular->text("mail", "mail", strtolower(SIGN_UP_EMAIL), SIGN_UP_EMAIL, 1);
$print.=$formular->password("pass1", "pass1", strtolower(SIGN_UP_PASSWORD), SIGN_UP_PASSWORD, 1);
$print.=$formular->password("pass2", "pass2", strtolower(SIGN_UP_RETYPE_PASSWORD), SIGN_UP_RETYPE_PASSWORD, 1);
$print.=$formular->select("lang", ['en','da'], ['English','Danish'], SIGN_UP_LANGUAGE, 'en');
$print.=$formular->select("securitylevel", [0,1,2], [SIGN_UP_SECURITY_LEVEL_1,SIGN_UP_SECURITY_LEVEL_2,SIGN_UP_SECURITY_LEVEL_3], SIGN_UP_SECURITY_LEVEL, 0);
$print.='<label id="antikeyloglabel">Anti Keylog</label><table id="antikeylog">
            <tr id="klu"><td><button n="1">&#9650;</button></td> <td><button n="2">&#9650;</button></td>  <td><button n="3">&#9650;</button></td></tr>
            <tr id="kln"><td n="1">0</td>       <td n="2">0</td>        <td n="3">0</td></tr>
            <tr id="kld"><td><button n="1">&#9660;</button></td> <td><button n="2">&#9660;</button></td>  <td><button n="3">&#9660;</button></td></tr>
        </table>'
        . '<div class="c"></div>';
$print.=$formular->button("signup_btn", SIGN_UP_TEXT);
$print.="</div>";
echo $print;
include 'util/bottom.php';
?>