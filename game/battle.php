<?php

include_once '../util/Db.php';
include_once '../model/Battlegroup.php';
include_once '../model/BattleCharacter.php';
include_once '../model/Powerset.php';
include_once '../model/Power.php';

if (!isset($_SESSION)) {
    session_start();
}

$PAGE_BATTLE=true;
$battleID = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) + 0;
$pointerAction = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_NUMBER_INT) + 0;

if(empty($pointerAction)){
    $pointerAction = 0;
}

include '../util/gametop.php';
if (isset($_SESSION['player'])) {
    $print = "";
    $battlegroup = unserialize($_SESSION['battlegroup']);
    $battlegroup = $battlegroup[$_SESSION['selectedbattlegroup']];
        if ($battlegroup->getIntInCombat() == $battleID) {
            $print .= "\n<battlegroup>\n";
            $print .= "</battlegroup>\n";
            //*** ADD ENEMY HERE
            $print .= "<enemygroup>";
            $print .= "</enemygroup>";
            //***
            $print .= "<battle id='$battleID'>\n";
            $table = "";
            for ($i = 0; $i < 16; $i++) {
                for ($j = 0; $j < 20; $j++) {
                    $table .= "\t<position x='$j' y='$i'></position>\n";
                }
            }
            $print .= $table;
            $print .= "</battle>\n";
            $print .= "<powers></powers>\n";
            $print .= "<footer></footer>\n";
        }
} else {
    header('location:/?not_logged_in=1');
}
echo $print;
//echo "<pre>";print_r($battlegroup);
include '../util/gamebottom.php';
?>