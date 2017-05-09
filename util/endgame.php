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
    $hasWon = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT) + 0;
    $player = unserialize($_SESSION['player']);
    $battlegroup = unserialize($_SESSION['battlegroup']);
    if (isset($_SESSION['selectedbattlegroup'])) {
        $battlegroup = $battlegroup[$_SESSION['selectedbattlegroup']];
        $DB = new DB();
        $playerID = $DB->select("select id from player where stremail = '{$player->getStrEmail()}' limit 1")->fetch()['id'];
        if ($battlegroup->getIntInCombat() != 0) {
            $DB->update('battlegroup', ['intincombat'], [0], "id={$battlegroup->getIntId()}");
            if ($hasWon) {
                //ADD POWERLEVEL-POINTS
                $characters = $DB->select("SELECT id,intpowerlevel FROM battlecharacter WHERE fk_battlegroup='{$battlegroup->getIntId()}'");
                while ($row = $characters->fetch()) {
                    $DB->update('battlecharacter', ['intpowerlevel'], [$row['intpowerlevel']+10], "id={$row['id']}");
                }
            } else {
                //SET FULL-HP TIMER
            }
        }
        $DB->refresh($playerID);
    }
}
?>