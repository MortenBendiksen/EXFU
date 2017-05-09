<?php

/**
 * Description of BattleCharacter
 *
 * @author Morten
 */
class BattleCharacter {

    private $intID, $strName, $strRole, $intPowerlevel, $intStrength, $powerset, $secPowerset;

    function __construct($intID, $strName, $strRole, $intPowerlevel, $intStrength, $powerset, $secPowerset) {
        $this->intID = $intID;
        $this->strName = $strName;
        $this->strRole = $strRole;
        $this->intPowerlevel = $intPowerlevel;
        $this->intStrength = $intStrength;
        $this->powerset = $powerset;
        $this->secPowerset = $secPowerset;
    }

    function getIntID() {
        return $this->intID;
    }

    function setIntID($intID) {
        $this->intID = $intID;
    }

    function getPowerset() {
        return $this->powerset;
    }

    function getSecPowerset() {
        return $this->secPowerset;
    }

    function setPowerset($powerset) {
        $this->powerset = $powerset;
    }

    function setSecPowerset($secPowerset) {
        $this->secPowerset = $secPowerset;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntPowerlevel() {
        return $this->intPowerlevel;
    }

    function getIntStrength() {
        return $this->intStrength;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function getStrRole() {
        return $this->strRole;
    }

    function setStrRole($strRole) {
        $this->strRole = $strRole;
    }

    function setIntPowerlevel($intPowerlevel) {
        $this->intPowerlevel = $intPowerlevel;
    }

    function setIntStrength($intStrength) {
        $this->intStrength = $intStrength;
    }

}
