<?php

/**
 * Description of EnemyOfPlanet
 *
 * @author Morten
 */
class EnemyOfPlanet {

    private $refEnemy, $refPlanet;

    function __construct($refEnemy, $refPlanet) {
        $this->refEnemy = $refEnemy;
        $this->refPlanet = $refPlanet;
    }

    function getRefEnemy() {
        return $this->refEnemy;
    }

    function getRefPlanet() {
        return $this->refPlanet;
    }

    function setRefEnemy($refEnemy) {
        $this->refEnemy = $refEnemy;
    }

    function setRefPlanet($refPlanet) {
        $this->refPlanet = $refPlanet;
    }

}
