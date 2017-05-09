<?php

/**
 * Description of Dayjob
 *
 * @author Morten
 */
class Dayjob {

    private $strName;

    function __construct($strName) {
        $this->strName = $strName;
    }

    function getStrName() {
        return $this->strName;
    }

    function setStrName($strName) {
        $this->strName = $strName;
    }

}
