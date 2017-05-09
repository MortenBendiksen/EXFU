<?php

include_once '../util/Db.php';
include_once '../model/Battlegroup.php';
include_once '../model/BattleCharacter.php';
include_once '../model/Powerset.php';
include_once '../model/Power.php';

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['player'])) {
    $print = "";
    $player = unserialize($_SESSION['player']);
    $battlegroup = unserialize($_SESSION['battlegroup']);
    $battlegroup = $battlegroup[$_SESSION['selectedbattlegroup']];
    if (isset($_SESSION['selectedbattlegroup'])) {
        if ($battlegroup->getIntInCombat() != 0) {
            header('location:battle.php?id=' . $battlegroup->getIntInCombat());
        } else {
            $DB = new DB();
            $randomFight = $DB->select("SELECT id FROM fight ORDER BY RAND() LIMIT 1");
            $fight = $randomFight->fetch();
            $DB->startBattle($fight['id'], $battlegroup->getIntID());
            $playerID = $DB->select("select id from player where stremail = '{$player->getStrEmail()}' limit 1")->fetch()['id'];
            $DB->refresh($playerID);
            header('location:../game/index.php');
        }
    }
}
?>