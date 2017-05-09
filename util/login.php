<?php

include_once 'Db.php';

if (!session_start()) {
    session_start();
}
if (!empty($_POST)) {
    $DB = new DB();
    $user = filter_input(INPUT_POST, 'u', FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_SPECIAL_CHARS);
    $anti = filter_input(INPUT_POST, 'a', FILTER_SANITIZE_SPECIAL_CHARS);
    $userID = $DB->verify($user, $pass, $anti);
    if ($userID == 0) {
        echo 0;
    } else {
        $DB->login($userID);
        echo 1;
    }
}
?>