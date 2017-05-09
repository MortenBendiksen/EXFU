<?php

/**
 * Description of Galaxy
 *
 * @author Morten
 */
class Galaxy {

    private $id, $strName, $arrSolarSystems;

    function __construct($id, $strName) {
        $this->id = $id;
        $this->strName = $strName;
    }

    function getId() {
        return $this->id;
    }

    function getSolarSystems() {
        return $this->arrSolarSystems;
    }

    function setId($id) {
        $this->id = $id;
    }

    function addSolarSystem($solarSystem) {
        $this->arrSolarSystems[] = $solarSystem;
    }

    function getStrName() {
        return $this->strName;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

}
