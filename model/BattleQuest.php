<?php

/**
 * Description of BattleQuest
 *
 * @author Morten
 */
class BattleQuest {

    private $refBattlegroup, $refQuest;

    function __construct($refBattlegroup, $refQuest) {
        $this->refBattlegroup = $refBattlegroup;
        $this->refQuest = $refQuest;
    }

    function getRefBattlegroup() {
        return $this->refBattlegroup;
    }

    function getRefQuest() {
        return $this->refQuest;
    }

    function setRefBattlegroup($refBattlegroup) {
        $this->refBattlegroup = $refBattlegroup;
    }

    function setRefQuest($refQuest) {
        $this->refQuest = $refQuest;
    }

}
