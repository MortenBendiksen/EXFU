<?php

include_once 'Db.php';
$DB = new DB();

$res = 0;
$battleID = filter_input(INPUT_GET, 'battle', FILTER_SANITIZE_NUMBER_INT) + 0;
$actorID = filter_input(INPUT_GET, 'actor', FILTER_SANITIZE_NUMBER_INT) + 0;
$actorTYPE = substr(filter_input(INPUT_GET, 'actor', FILTER_SANITIZE_STRING), 0, 1);
$powerID = filter_input(INPUT_GET, 'power', FILTER_SANITIZE_NUMBER_INT) + 0;
$targetID = filter_input(INPUT_GET, 'target', FILTER_SANITIZE_NUMBER_INT) + 0;
$targetTYPE = substr(filter_input(INPUT_GET, 'target', FILTER_SANITIZE_STRING), 0, 1);
$moveX = filter_input(INPUT_GET, 'movex', FILTER_SANITIZE_NUMBER_INT) + 0;
$moveY = filter_input(INPUT_GET, 'movey', FILTER_SANITIZE_NUMBER_INT) + 0;
//$cost = filter_input(INPUT_GET, 'cost', FILTER_SANITIZE_NUMBER_INT) + 0;
if (!empty($battleID) && !empty($actorID) && !empty($actorTYPE) && !empty($powerID) && !empty($targetID) && !empty($targetTYPE) && (!empty($moveX) || $moveX == 0) && (!empty($moveY) || $moveY == 0)) {
    if ($actorTYPE == "p") {
        $SQLactor = 'playeractor';
        $validateSQLactor = "battlecharacter";
        $validateSQL = "powerset ON battlecharacter.fk_powerset = powerset.id OR battlecharacter.fk_secondarypowerset = powerset.id JOIN powers ON powers.fk_powerset = powerset";
    } else {
        $SQLactor = 'enemyactor';
        $validateSQLactor = "enemy";
        $validateSQL = "enemypowers ON enemypowers.fk_enemy = enemy.id JOIN powers ON enemypowers.fk_powers = powers";
    }
    if ($targetTYPE == "p") {
        $SQLtarget = 'playertarget';
    } else {
        $SQLtarget = 'enemytarget';
    }

    $fields = ['fk_battle', $SQLactor, 'fk_power', $SQLtarget, 'intmovex', 'intmovey', 'intdate'];
    $validate = $DB->select("SELECT $validateSQLactor.id FROM $validateSQLactor JOIN $validateSQL.id WHERE $validateSQLactor.id = $actorID AND powers.id = $powerID");
    if ($row = $validate->fetch()) {
        $action = $DB->insert("actions", $fields, [$battleID, $actorID, $powerID, $targetID, $moveX, $moveY, time()]);
    } else {
        $res = "BATTLE_POWER_NOT_FOUND";
    }
} else {
    $res = "BATTLE_MISSING_PARAMETERS";
}
echo $res;
