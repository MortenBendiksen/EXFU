<?php

/**
 * Description of EnemyPower
 *
 * @author Morten
 */
class EnemyPower {

    private $refEnemy, $refPower;

    function __construct($refEnemy, $refPower) {
        $this->refEnemy = $refEnemy;
        $this->refPower = $refPower;
    }

    function getRefEnemy() {
        return $this->refEnemy;
    }

    function getRefPower() {
        return $this->refPower;
    }

    function setRefEnemy($refEnemy) {
        $this->refEnemy = $refEnemy;
    }

    function setRefPower($refPower) {
        $this->refPower = $refPower;
    }

}
