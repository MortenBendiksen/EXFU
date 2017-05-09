<?php

/**
 * Description of Questline
 *
 * @author Morten
 */
class Questline {

    private $strTitle;

    function __construct($strTitle) {
        $this->strTitle = $strTitle;
    }

    function getStrTitle() {
        return $this->strTitle;
    }

    function setStrTitle($strTitle) {
        $this->strTitle = $strTitle;
    }

}
