<?php

$PAGE_USER = true;

include_once 'model/Player.php';
include_once 'model/Battlegroup.php';
include_once 'model/BattleCharacter.php';
include_once 'util/DB.php';
include_once 'util/Calc.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT) + 0;
$Calc = new Calc();
$DB = new DB();
$print = "";
$groupText = "";

$getUser = $DB->select("SELECT strdisplayname,intlogout,strlanguage,intplayerlevel,intplayerxp FROM player WHERE id=$id LIMIT 1")->fetch();
$strdisplayname = $getUser['strdisplayname'];
$intlogout = $getUser['intlogout'];
$strlanguage = $getUser['strlanguage'];
$intplayerlevel = $getUser['intplayerlevel'];
$intplayerxp = $getUser['intplayerxp'];
$maxXPtoLevel = $Calc->maxXPtoLevel($intplayerlevel);
$procentXP = round(($intplayerxp / $maxXPtoLevel) * 100);

include 'util/top.php';
if (isset($id)) {
    $print .= "<h2>$strdisplayname<div id='level'>{$intplayerlevel}<div id='maxxp'>$intplayerxp/$maxXPtoLevel<div id='xp' style='width:$procentXP%'></div></div></div></h2>";
} else {
    $print .= "<h2>" . USER_NOT_FOUND . "</h2>";
}
$print .="<div id='groups'>";
$getGroup = $DB->select("SELECT id,strname FROM battlegroup WHERE fk_player = $id");
while ($group = $getGroup->fetch()) {
    $characterText = "";
    $groupID = $group['id'];
    $groupname = $group['strname'];
    $getCharacter = $DB->select("SELECT battlecharacter.strname,battlecharacter.intpowerlevel,battlecharacter.fk_role,primarypowerset.strname AS 'priname',secondarypowerset.strname AS 'secname' FROM battlecharacter LEFT JOIN powerset primarypowerset ON primarypowerset.id = battlecharacter.fk_powerset LEFT JOIN powerset secondarypowerset ON secondarypowerset.id = battlecharacter.fk_secondarypowerset WHERE fk_battlegroup=$groupID");
    while ($character = $getCharacter->fetch()) {
        $charactername = $character['strname'];
        $characterpowerlevel = $character['intpowerlevel'];
        $characterrole = $character['fk_role'];
        $characterprimary = $character['priname'];
        $charactersecondary = $character['secname'];
        $characterText .= "<div class='character' role='$characterrole'>$charactername<div class='level'>Powerlevel: $characterpowerlevel</div><div class='power' pri='1'>$characterprimary</div><div class='power'>$charactersecondary</div></div>";
    }
    //$characterText .= "<div class='character' role='\$characterrole'>\$charactername<div class='level'>Powerlevel: \$characterpowerlevel</div><div class='power' pri='1'>\$characterprimary</div><div class='power'>\$charactersecondary</div></div>";
    //$characterText .= "<div class='character' role='\$characterrole'>\$charactername<div class='level'>Powerlevel: \$characterpowerlevel</div><div class='power' pri='1'>\$characterprimary</div><div class='power'>\$charactersecondary</div></div>";
    $groupText .="<div class='group' group='$groupID'><div class='name'>$groupname</div>$characterText<div class='c'></div></div>";
}
$print .="$groupText</div>";
echo $print;
include 'util/bottom.php';
?>