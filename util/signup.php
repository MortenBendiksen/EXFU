<?php

include_once 'Db.php';
$DB = new DB();
if (isset($_POST['cname'])) {
    $c = 1;
    $displayname = filter_input(INPUT_POST, 'cname', FILTER_SANITIZE_SPECIAL_CHARS);
    $cname = $DB->select("select id from player where strdisplayname = '$displayname'");
    while ($cname->fetch()) {
        $c = 0;
    }
    $res = $c;
} elseif (isset($_POST['cmail'])) {
    $c = 1;
    $email = filter_input(INPUT_POST, 'cmail', FILTER_SANITIZE_SPECIAL_CHARS);
    $cmail = $DB->select("select id from player where stremail = '$email'");
    while ($cmail->fetch()) {
        $c = 0;
    }
    $res = $c;
} else {
    $displayname = filter_input(INPUT_POST, 'displayname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $language = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_SPECIAL_CHARS);
    $securitylevel = filter_input(INPUT_POST, 'securitylevel', FILTER_SANITIZE_SPECIAL_CHARS);
    $antikeylog = filter_input(INPUT_POST, 'antikeylog', FILTER_SANITIZE_SPECIAL_CHARS);
    //----- HASHING
    switch ($securitylevel) {
        case 1:
            $pass_cost = 5;
            $anti_cost = 5;
            break;
        case 2:
            $pass_cost = 15;
            $anti_cost = 8;
        default:
            $pass_cost = 8;
            $anti_cost = 4;
            break;
    }
    $password_hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => $pass_cost]);
    $antikeylog_hash = password_hash($antikeylog, PASSWORD_BCRYPT, ["cost" => $anti_cost]);
    $DB->insert('player', ['strdisplayname', 'strlanguage', 'intsecuritylevel', 'stremail', 'strpassword', 'intantikeylog'], [$displayname, $language, $securitylevel, $email, $password_hash, $antikeylog_hash]);
    $res = 1;
}
echo $res;
?>
