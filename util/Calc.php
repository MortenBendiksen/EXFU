<?php

/**
 *
 * @author Morten
 */
class Calc {

    function __construct() {
        //...
    }

    public function maxXPtoLevel($currentLevel) {
        $result = -1;
        $currentLevel = $currentLevel + 0;
        if (is_int($currentLevel) && $currentLevel < 20) {
            $currentLevel++;
            $result = (($currentLevel * $currentLevel) * 50) * ($currentLevel / 20);
        }
        return $result;
    }

}
