<?php

/**
 * Description of Quest
 *
 * @author Morten
 */
class Quest {

    private $strTitle, $intPlayerXPonComplete, $strQuestText, $intQuestInLine;

    function __construct($strTitle, $intPlayerXPonComplete, $strQuestText, $intQuestInLine) {
        $this->strTitle = $strTitle;
        $this->intPlayerXPonComplete = $intPlayerXPonComplete;
        $this->strQuestText = $strQuestText;
        $this->intQuestInLine = $intQuestInLine;
    }

    function getStrTitle() {
        return $this->strTitle;
    }

    function getIntPlayerXPonComplete() {
        return $this->intPlayerXPonComplete;
    }

    function getStrQuestText() {
        return $this->strQuestText;
    }

    function getIntQuestInLine() {
        return $this->intQuestInLine;
    }

    function setStrTitle($strTitle) {
        $this->strTitle = $strTitle;
    }

    function setIntPlayerXPonComplete($intPlayerXPonComplete) {
        $this->intPlayerXPonComplete = $intPlayerXPonComplete;
    }

    function setStrQuestText($strQuestText) {
        $this->strQuestText = $strQuestText;
    }

    function setIntQuestInLine($intQuestInLine) {
        $this->intQuestInLine = $intQuestInLine;
    }

}
