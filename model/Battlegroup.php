<?php

/**
 * Description of Battlegroup
 *
 * @author Morten
 */
class Battlegroup {

    private $intID, $strName, $strShipName, $intInCombat, $colShipColor, $intShipInternet, $intShipCPU, $arrMembers;

    function __construct($intID, $strName, $intInCombat, $strShipName, $colShipColor, $intShipInternet, $intShipCPU) {
        $this->intID = $intID;
        $this->strName = $strName;
        $this->strShipName = $strShipName;
        $this->colShipColor = $colShipColor;
        $this->intShipInternet = $intShipInternet;
        $this->intShipCPU = $intShipCPU;
        $this->intInCombat = $intInCombat;
    }
    function getIntID() {
        return $this->intID;
    }

    function setIntID($intID) {
        $this->intID = $intID;
    }

        function getStrName() {
        return $this->strName;
    }

    function getStrShipName() {
        return $this->strShipName;
    }

    function getIntInCombat() {
        return $this->intInCombat;
    }

    function setIntInCombat($intInCombat) {
        $this->intInCombat = $intInCombat;
    }

    function getColShipColor() {
        return $this->colShipColor;
    }

    function getIntShipInternet() {
        return $this->intShipInternet;
    }

    function getIntShipCPU() {
        return $this->intShipCPU;
    }

    function getArrMembers() {
        return $this->arrMembers;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setStrShipName($strShipName) {
        $this->strShipName = $strShipName;
    }

    function setColShipColor($colShipColor) {
        $this->colShipColor = $colShipColor;
    }

    function setIntShipInternet($intShipInternet) {
        $this->intShipInternet = $intShipInternet;
    }

    function setIntShipCPU($intShipCPU) {
        $this->intShipCPU = $intShipCPU;
    }

    function addMember($arrMember) {
        $this->arrMembers[] = $arrMember;
    }

}
