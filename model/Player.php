<?php

/**
 * Description of Player
 *
 * @author Morten
 */
class Player {

    private $intId, $strDisplayName, $strLanguage, $intSecurityLevel, $strEmail, $strPassword, $intAntiKeylog, $intPlayerLevel, $intPlayerXP;

    function __construct($intId, $strDisplayName, $strLanguage, $intSecurityLevel, $strEmail, $strPassword, $intAntiKeylog, $intPlayerLevel, $intPlayerXP) {
        $this->intId = $intId;
        $this->strDisplayName = $strDisplayName;
        $this->strLanguage = $strLanguage;
        $this->intSecurityLevel = $intSecurityLevel;
        $this->strEmail = $strEmail;
        $this->strPassword = $strPassword;
        $this->intAntiKeylog = $intAntiKeylog;
        $this->intPlayerLevel = $intPlayerLevel;
        $this->intPlayerXP = $intPlayerXP;
    }

    function getIntId() {
        return $this->intId;
    }

    function setIntId($intId) {
        $this->intId = $intId;
    }

    function getStrLanguage() {
        return $this->strLanguage;
    }

    function setStrLanguage($strLanguage) {
        $this->strLanguage = $strLanguage;
    }

    function getStrDisplayName() {
        return $this->strDisplayName;
    }

    function getIntSecurityLevel() {
        return $this->intSecurityLevel;
    }

    function getStrEmail() {
        return $this->strEmail;
    }

    function getStrPassword() {
        return $this->StrPassword;
    }

    function getIntAntiKeylog() {
        return $this->intAntiKeylog;
    }

    function getIntPlayerLevel() {
        return $this->intPlayerLevel;
    }

    function getIntPlayerXP() {
        return $this->intPlayerXP;
    }

    function setStrDisplayName($strDisplayName) {
        $this->strDisplayName = $strDisplayName;
    }

    function setIntSecurityLevel($intSecurityLevel) {
        $this->intSecurityLevel = $intSecurityLevel;
    }

    function setStrEmail($strEmail) {
        $this->strEmail = $strEmail;
    }

    function setStrPassword($strPassword) {
        $this->strPassword = $strPassword;
    }

    function setIntAntiKeylog($intAntiKeylog) {
        $this->intAntiKeylog = $intAntiKeylog;
    }

    function setIntPlayerLevel($intPlayerLevel) {
        $this->intPlayerLevel = $intPlayerLevel;
    }

    function setIntPlayerXP($intPlayerXP) {
        $this->intPlayerXP = $intPlayerXP;
    }

}
