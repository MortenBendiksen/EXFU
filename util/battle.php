<?php

include_once 'Db.php';
$battleID = filter_input(INPUT_GET, 'battle', FILTER_SANITIZE_NUMBER_INT) + 0;
if (!is_int($battleID)) {
    $battleID = 0;
}
$DB = new DB();
$characters = "";
$enemies = "";
$actions = "";
$battle = $DB->select("SELECT battle.fk_battlegroup AS 'battlegroup', battle.fk_fight AS 'enemylist', fight.intenemypowerlevel FROM battle JOIN battlegroup ON battlegroup.id = battle.fk_battlegroup JOIN fight ON fight.id = battle.fk_fight WHERE battle.id = $battleID");
if ($row = $battle->fetch()) {
    $battlegroup = $row['battlegroup'];
    $enemylist = $row['enemylist'];
    $enemypowerlevel = $row['intenemypowerlevel'];
    $chars = $DB->select("SELECT battlestatsnapshot.intpowerlevel,battlestatsnapshot.inttalents,battlecharacter.id AS 'characterID',battlecharacter.strname,battlecharacter.fk_role,battlecharacter.fk_powerset AS 'primarypowers', battlecharacter.fk_secondarypowerset AS 'secondarypowers' FROM battlestatsnapshot JOIN battlecharacter ON battlecharacter.id = battlestatsnapshot.fk_battlecharacter WHERE fk_battle = $battleID");
    while ($row = $chars->fetch()) {
        $characters .= "<character id='{$row['characterID']}' primarypowerset='{$row['primarypowers']}' secondarypowerset='{$row['secondarypowers']}' talents='{$row['inttalents']}' powerlevel='{$row['intpowerlevel']}' role='{$row['fk_role']}' name='{$row['strname']}'>";
        $characters .= "<primarypowers>";
        $primarypowers = $DB->select("SELECT * FROM powers WHERE fk_powerset = {$row['primarypowers']}");
        while ($rowpri = $primarypowers->fetch()) {
            $characters .= "<power id='{$rowpri['id']}' powerset='{$row['primarypowers']}' output='{$rowpri['inttotaloutput']}' rounds='{$rowpri['introunds']}' cooldown='{$rowpri['intcooldown']}' target='{$rowpri['inttarget']}' cost='{$rowpri['intcost']}' thread='{$rowpri['intthread']}' name='{$rowpri['strname']}'></power>";
        }
        $characters .= "</primarypowers>";

        $characters .= "<secondarypowers>";
        $secondarypowers = $DB->select("SELECT * FROM powers WHERE fk_powerset = {$row['secondarypowers']}");
        while ($rowsec = $secondarypowers->fetch()) {
            $characters .= "<power id='{$rowsec['id']}' powerset='{$row['secondarypowers']}' output='{$rowsec['inttotaloutput']}' rounds='{$rowsec['introunds']}' cooldown='{$rowsec['intcooldown']}' target='{$rowsec['inttarget']}' cost='{$rowsec['intcost']}' thread='{$rowsec['intthread']}' name='{$rowsec['strname']}'></power>";
        }
        $characters .= "</secondarypowers>";
        $characters .= "</character>";
    }
// ENEMIES
    $enemy = $DB->select("SELECT enemy.id AS 'enemyID',enemy.strname AS 'enemyname',enemy.inttype,enemy.intrank FROM fight JOIN battleenemy ON battleenemy.fk_fight = fight.id JOIN enemy ON enemy.id = battleenemy.fk_enemy WHERE fight.id = $enemylist");
    while ($row = $enemy->fetch()) {
        $enemyname = $row['enemyname'];
        $enemytype = $row['inttype'];
        $enemyrank = $row['intrank'];
        $enemyID = $row['enemyID'];
        $enemies .= "<enemy id='{$enemyID}' type='$enemytype' rank='$enemyrank' powerlevel='$enemypowerlevel' name='$enemyname'>";
        $enemypowers = $DB->select("SELECT * FROM enemypowers JOIN powers ON fk_powers = powers.id WHERE fk_enemy = $enemyID");
        $enemies .= "<powers>";
        while ($row = $enemypowers->fetch()) {
            $enemies .= "<power id='{$row['id']}' powerset='{$row['fk_powerset']}' output='{$row['inttotaloutput']}' rounds='{$row['introunds']}' cooldown='{$row['intcooldown']}' target='{$row['inttarget']}' cost='{$row['intcost']}' thread='{$row['intthread']}' name='{$row['strname']}'></power>";
        }
        $enemies .= "</powers>";
        $enemies .= "</enemy>";
    }

//ACTIONS
    $c = 1;
    $action = $DB->select("SELECT * FROM actions JOIN powers ON actions.fk_power = powers.id WHERE fk_battle = $battleID");
    while ($row = $action->fetch()) {
        $cost = 0;
        if (!empty($row['playeractor'])) {
            $actor = "p" . $row['playeractor'];
        } else {
            $actor = "e" . $row['enemyactor'];
        }
        if (!empty($row['playertarget'])) {
            $target = "p" . $row['playertarget'];
        } else {
            $target = "e" . $row['enemytarget'];
        }
        $actions .= "<action id='$c' actor='$actor' power='{$row['fk_power']}' target='$target' movex='{$row['intmovex']}' movey='{$row['intmovey']}'></action>";
        $c++;
    }
}
/////////////////////////////////////////////////////////////

$xml = "<?xml version='1.0' encoding='UTF-8'?>";
$xml .= "<battle id='$battleID'>";
$xml .= "<battlegroup>$characters</battlegroup>";
$xml .= "<enemygroup>$enemies</enemygroup>";
$xml .= "<actions>$actions</actions>";
$xml .= "</battle>";
header("Content-type: text/xml");
echo $xml;
?>