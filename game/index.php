<?php

include_once '../util/Db.php';
include_once '../model/Battlegroup.php';
include_once '../model/BattleCharacter.php';
include_once '../model/Powerset.php';
include_once '../model/Power.php';

if (!isset($_SESSION)) {
    session_start();
}
include '../util/gametop.php';
if (isset($_SESSION['player'])) {
    $print = "";
    $battlegroup = unserialize($_SESSION['battlegroup']);
    if (isset($_SESSION['selectedbattlegroup'])) {
        $battlegroup = $battlegroup[$_SESSION['selectedbattlegroup']];
        if ($battlegroup->getIntInCombat() != 0) {
            header('location:battle.php?id=' . $battlegroup->getIntInCombat());
        } else {
            $print .="<img src='../css/images/0.gif' id='ship' usemap='#shipmap' />"
                    . "<map name='shipmap'>"
                    . "<area class='ship_btn' shape='poly' name='bridge' coords='169,34,261,115,169,148,81,116' href='#' alt='Main-Bridge'>"
                    . "<area class='ship_btn' shape='poly' name='battle' coords='221,422,220,291,287,293,303,421' href='../util/startbattle.php' alt='Battle-Simulator'>"
                    . "<area class='ship_btn' shape='poly' name='engine' coords='39,427,301,426,276,470,62,470' href='#' alt='Engine'>"
                    . "</map>";
        }
    } else {
        if (count($battlegroup) > 0) {
            $c = 0;
            foreach ($battlegroup as $group) {
                $print.= "<div class='group' group='$c'>" . $group->getStrName();
                foreach ($group->getArrMembers() as $character) {
                    $print .= " " . $character->getStrName();
                }
                $print.='<button>' . GAME_SELECT_GROUP . '</button></div>';
                $c++;
            }
        }
        $print.='<div id="new" class="group">' . CREATE_NEW_GROUP . '</div>';
    }
} else {
    header('location:/?not_logged_in=1');
}
echo $print;
//echo "<pre>";print_r($battlegroup);
include '../util/gamebottom.php';
?>