<?php

include_once '../util/Db.php';
include_once '../model/Player.php';
if (!isset($_SESSION)) {
    session_start();
}
$groupname = filter_input(INPUT_POST, 'groupname', FILTER_SANITIZE_SPECIAL_CHARS);
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
$mainpower = filter_input(INPUT_POST, 'mainpower', FILTER_SANITIZE_SPECIAL_CHARS);
$secondarypower = filter_input(INPUT_POST, 'secondarypower', FILTER_SANITIZE_SPECIAL_CHARS);
$role = explode("_", $role)[1];
if (isset($_SESSION['player']) && $groupname != "" && $name != "" && $role != "" && $mainpower != "" && $secondarypower != "") {
    $player = unserialize($_SESSION['player']);
    $playerID = 0;
    $mainpowerID = 0;
    $secondarypowerID = 0;
    $DB = new DB();
    $db_PlayerID = $DB->select("select id from player where stremail = '{$player->getStrEmail()}' limit 1");
    while ($row = $db_PlayerID->fetch()) {
        $playerID = $row['id'];
    }
    $db_RoleID = $DB->select("select id from role where strname like '$role%' limit 1");
    while ($row = $db_RoleID->fetch()) {
        $roleID = $row['id'];
    }
    $db_MainID = $DB->select("select id from powerset where strname like '$mainpower%' limit 1");
    while ($row = $db_MainID->fetch()) {
        $mainpowerID = $row['id'];
    }
    $db_SecondID = $DB->select("select id from powerset where strname like '$secondarypower%' limit 1");
    while ($row = $db_SecondID->fetch()) {
        $secondarypowerID = $row['id'];
    }
    $DB->insert('battlegroup', ['strname', 'fk_player'], [$groupname, $playerID]);
    $groupID = $DB->getIntinsertID();
    $DB->insert('battlecharacter', ['strname', 'fk_role', 'fk_battlegroup', 'fk_powerset', 'fk_secondarypowerset'], [$name, $roleID, $groupID, $mainpowerID, $secondarypowerID],true);
    $DB->refresh($playerID);
    $res = 1;
} else {
    $res = 0;
}
echo $res;
?>