<?php

/**
 * Description of NPC
 *
 * @author Morten
 */
class NPC {

    private $strName, $intType, $strAppearancePath;

    function __construct($strName, $intType, $strAppearancePath) {
        $this->strName = $strName;
        $this->intType = $intType;
        $this->strAppearancePath = $strAppearancePath;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntType() {
        return $this->intType;
    }

    function getStrAppearancePath() {
        return $this->strAppearancePath;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setIntType($intType) {
        $this->intType = $intType;
    }

    function setStrAppearancePath($strAppearancePath) {
        $this->strAppearancePath = $strAppearancePath;
    }

}
