<?php
/**
 * Created by PhpStorm.
 * User: Fercho
 * Date: 29/06/2019
 * Time: 01:15 PM
 */

class StringUtil{

    static public function startsWith ($string, $startString)
    {
        $len = strlen($startString);
        return (substr($string, 0, $len) === $startString);
    }

}