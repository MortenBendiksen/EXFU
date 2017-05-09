<?php

/**
 * Description of Enemy
 *
 * @author Morten
 */
class Enemy {

    private $strName, $intType, $intRank;

    function __construct($strName, $intType, $intRank) {
        $this->strName = $strName;
        $this->intType = $intType;
        $this->intRank = $intRank;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntType() {
        return $this->intType;
    }

    function getIntRank() {
        return $this->intRank;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setIntType($intType) {
        $this->intType = $intType;
    }

    function setIntRank($intRank) {
        $this->intRank = $intRank;
    }

}
