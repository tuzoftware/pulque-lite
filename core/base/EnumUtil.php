<?php

/**
 * Created by PhpStorm.
 * User: Solutions
 * Date: 14/02/2017
 * Time: 01:17 PM
 */
class EnumUtil
{
    public static function buscarKey($claseReflexion,$key) {
        $clase = new ReflectionClass($claseReflexion);
        $constantes=$clase->getConstants();
        foreach ($constantes as $tkey=>$tvalue){
            if($tkey===$key){
                return true;
            }
        }
        return false;
    }

    public static function buscarValue($claseReflexion,$value) {
        $clase = new ReflectionClass($claseReflexion);
        $constantes=$clase->getConstants();
        foreach ($constantes as $tkey=>$tvalue){
            if($tvalue===$value){
                return true;
            }
        }
        return false;
    }


}