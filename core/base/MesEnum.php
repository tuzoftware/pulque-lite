<?php

/**
 * Class RolEnum aqui van todos los PERMISOS
 * Se deben de colocar en orden alfabético
 * los permisos pueden ser genericos o especificos
 */
class MesEnum
{

    const ENERO = 1;

    const FEBRERO=2;

    const MARZO=3;

    const ABRIL=4;

    const MAYO=5;

    const JUNIO=6;

    const JULIO=7;

    const AGOSTO=8;

    const SEPTIEMBRE=9;

    const OCTUBRE=10;

    const NOVIEMBRE=11;

    const DICIEMBRE=12;

    public static function getConstants() {
        $clase = new ReflectionClass(__CLASS__);
        return $clase->getConstants();
    }

}