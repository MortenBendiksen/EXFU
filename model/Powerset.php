<?php

/**
 * Description of Powerset
 *
 * @author Morten
 */
class Powerset {

    private $strName, $intType, $strImagePath, $strAudioPath, $powers;

    function __construct($strName, $intType, $strImagePath, $strAudioPath) {
        $this->strName = $strName;
        $this->intType = $intType;
        $this->strImagePath = $strImagePath;
        $this->strAudioPath = $strAudioPath;
    }

    function getPowers() {
        return $this->powers;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntType() {
        return $this->intType;
    }

    function getStrImagePath() {
        return $this->strImagePath;
    }

    function getStrAudioPath() {
        return $this->strAudioPath;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setIntType($intType) {
        $this->intType = $intType;
    }

    function setStrImagePath($strImagePath) {
        $this->strImagePath = $strImagePath;
    }

    function setStrAudioPath($strAudioPath) {
        $this->strAudioPath = $strAudioPath;
    }

    function addPower($power) {
        $this->powers[] = $power;
    }

}
