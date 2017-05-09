<?php

if (!isset($_SESSION)) {
    session_start();
}
$group = filter_input(INPUT_POST, 'group', FILTER_SANITIZE_SPECIAL_CHARS);
if ($group != "") {
    $_SESSION['selectedbattlegroup'] = $group;
    $res = 1;
} else {
    $res = 0;
}

echo $res;
