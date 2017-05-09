<?php

/**
 * Description of Planet
 *
 * @author Morten
 */
class Planet {

    private $id, $strName, $intType, $intGravity, $intRadiation, $douPosition, $intRotation;

    function __construct($id, $strName, $intType, $intGravity, $intRadiation, $douPosition, $intRotation) {
        $this->id = $id;
        $this->strName = $strName;
        $this->intType = $intType;
        $this->intGravity = $intGravity;
        $this->intRadiation = $intRadiation;
        $this->douPosition = $douPosition;
        $this->intRotation = $intRotation;
    }

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntType() {
        return $this->intType;
    }

    function getIntGravity() {
        return $this->intGravity;
    }

    function getIntRadiation() {
        return $this->intRadiation;
    }

    function getDouPosition() {
        return $this->douPosition;
    }

    function getIntRotation() {
        return $this->intRotation;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setIntType($intType) {
        $this->intType = $intType;
    }

    function setIntGravity($intGravity) {
        $this->intGravity = $intGravity;
    }

    function setIntRadiation($intRadiation) {
        $this->intRadiation = $intRadiation;
    }

    function setDouPosition($douPosition) {
        $this->douPosition = $douPosition;
    }

    function setIntRotation($intRotation) {
        $this->intRotation = $intRotation;
    }

}
