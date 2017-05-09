<?php

include_once '../util/language.php';
if (!isset($_SESSION)) {
    session_start();
}
include_once '../util/DB.php';
include_once '../model/SolarSystem.php';
include_once '../model/Planet.php';
include_once '../model/Galaxy.php';

$DB = new DB();
$print = "";
$isgalaxy = filter_input(INPUT_GET, 'galaxy', FILTER_SANITIZE_NUMBER_INT) + 0;
$issolarsystem = filter_input(INPUT_GET, 'solarsystem', FILTER_SANITIZE_NUMBER_INT) + 0;
$isplanet = filter_input(INPUT_GET, 'planet', FILTER_SANITIZE_NUMBER_INT) + 0;
$pos = "1:1:1:1:1"; //battlegroup Position  (GALAXY:SOLARSYSTEM:PLANET:X:Y)
$pos = explode(":", $pos);
if (count($pos) == 5) {
    $pos_galaxy = intval($pos[0]);
    $pos_solarsystem = intval($pos[1]);
    $pos_planet = intval($pos[2]);
    $pos_x = intval($pos[3]);
    $pos_y = intval($pos[4]);
}
if (isset($isgalaxy) && $isgalaxy != "" || ($isgalaxy == "" && $issolarsystem == "" && $isplanet == "")) {
    //show galaxy
    $print.="<galaxies>";
    $galaxySQL = $DB->select("SELECT * FROM galaxy LIMIT 1");
    if ($galaxySQL = $galaxySQL->fetch()) {
        $galaxy = new Galaxy($galaxySQL['id'], $galaxySQL['strname']);
        $galaxyID = $galaxySQL['id'];
        $print .= $galaxy->getStrName();
        $solarsystemSQL = $DB->select("SELECT * FROM solarsystem WHERE fk_galaxy = $galaxyID");
        while ($solarsystem = $solarsystemSQL->fetch()) {
            $solarsystemObj = new SolarSystem($solarsystem['id'], $solarsystem['strname'], $solarsystem['intpositionx'], $solarsystem['intpositiony']);
            $galaxy->addSolarSystem($solarsystemObj);
        }
        foreach ($galaxy->getSolarSystems() as $system) {
            $solarsystemID = $system->getId();
            $x = $system->getIntPositionX();
            $y = $system->getIntPositionY();
            $name = $system->getStrName();
            $print.= "<solarsystem ss='$solarsystemID' style='left:{$x}vh;top:{$y}vh;'>$name</solarsystem>";
        }
    }
    $print.="</galaxies>";
} elseif (isset($issolarsystem) && $issolarsystem != "") {
    $solatsystemSQL = $DB->select("SELECT * FROM solarsystem WHERE id='$issolarsystem' LIMIT 1");
    if ($solatsystemSQL = $solatsystemSQL->fetch()) {
        $print.="<solarsystems parent='{$solatsystemSQL['fk_galaxy']}'>";
        $solarsystem = new SolarSystem($issolarsystem, $solatsystemSQL['strname'], $solatsystemSQL['intpositionx'], $solatsystemSQL['intpositiony']);
    }
    $print .= $solarsystem->getStrName();
    $planetSQL = $DB->select("SELECT * FROM planet WHERE fk_solarsystem = $issolarsystem ORDER BY intposition DESC");
    while ($row = $planetSQL->fetch()) {
        $planet = new Planet($row['id'], $row['strname'], $row['inttype'], $row['intgravity'], $row['intradiation'], $row['intposition'], $row['introtation']);
        $solarsystem->addPlanet($planet);
    }
    foreach ($solarsystem->getPlanets() as $planet) {
        $planetID = $planet->getId();
        $position = $planet->getDouPosition();
        $gravity = $planet->getIntGravity();
        $radiation = $planet->getIntRadiation();
        $rotation = $planet->getIntRotation();
        $type = $planet->getIntType();
        $name = $planet->getStrName();
        $print.= "<planet pp='$planetID' position='$position' gravity='$gravity' radiation='$radiation' rotation='$rotation' type='$type'><div>$name</div></planet>";
    }
    $print.="<sun></sun></solarsystems>";
} elseif (isset($isplanet) && $isplanet != "") {
    //show planet
    $planetSQL = $DB->select("SELECT * FROM planet WHERE id = $isplanet LIMIT 1");
    if ($row = $planetSQL->fetch()) {
        $print.="<planets parent='{$row['fk_solarsystem']}'>";
        $planet = new Planet($row['id'], $row['strname'], $row['inttype'], $row['intgravity'], $row['intradiation'], $row['intposition'], $row['introtation']);
        $planetID = $planet->getId();
        $position = $planet->getDouPosition();
        $gravity = $planet->getIntGravity();
        $radiation = $planet->getIntRadiation();
        $rotation = $planet->getIntRotation();
        $type = $planet->getIntType();
        $name = $planet->getStrName();
        $print.= "$name<planet pp='$planetID' gravity='$gravity' radiation='$radiation' rotation='$rotation' type='$type'></planet>";
    }
    $print.="</planets>";
} else {
    
}
echo $print;
echo "<battlegroup galaxy='$pos_galaxy' solarsystem='$pos_solarsystem' planet='$pos_planet' x='$pos_x' y='$pos_y'></battlegroup>";
?>