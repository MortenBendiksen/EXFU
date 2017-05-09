<?php

/**
 * Description of Power
 *
 * @author Morten
 */
class Power {

    private $strName, $intTotalOutput, $intRounds, $intCooldown, $intTarget;

    function __construct($strName, $intTotalOutput, $intRounds, $intCooldown, $intTarget) {
        $this->strName = $strName;
        $this->intTotalOutput = $intTotalOutput;
        $this->intRounds = $intRounds;
        $this->intCooldown = $intCooldown;
        $this->intTarget = $intTarget;
    }

    function getStrName() {
        return $this->strName;
    }

    function getIntTotalOutput() {
        return $this->intTotalOutput;
    }

    function getIntRounds() {
        return $this->intRounds;
    }

    function getIntCooldown() {
        return $this->intCooldown;
    }

    function getIntTarget() {
        return $this->intTarget;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

    function setIntTotalOutput($intTotalOutput) {
        $this->intTotalOutput = $intTotalOutput;
    }

    function setIntRounds($intRounds) {
        $this->intRounds = $intRounds;
    }

    function setIntCooldown($intCooldown) {
        $this->intCooldown = $intCooldown;
    }

    function setIntTarget($intTarget) {
        $this->intTarget = $intTarget;
    }

}
