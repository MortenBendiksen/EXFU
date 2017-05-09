<?php

/**
 * Description of SolarSystem
 *
 * @author Morten
 */
class SolarSystem {

    private $id, $strName, $intPositionX, $intPositionY, $arrPlanets;

    function __construct($id, $strName, $intPositionX, $intPositionY) {
        $this->id = $id;
        $this->strName = $strName;
        $this->intPositionX = $intPositionX;
        $this->intPositionY = $intPositionY;
        $this->arrPlanets = [];
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getPlanets() {
        return $this->arrPlanets;
    }

    function addPlanet($planet) {
        $this->arrPlanets[] = $planet;
    }

    function getStrName() {
        return $this->strName;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }
    function getIntPositionX() {
        return $this->intPositionX;
    }

    function getIntPositionY() {
        return $this->intPositionY;
    }

    function setIntPositionX($intPositionX) {
        $this->intPositionX = $intPositionX;
    }

    function setIntPositionY($intPositionY) {
        $this->intPositionY = $intPositionY;
    }
}
