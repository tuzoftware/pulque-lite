<?php

/**
 * Class RolEnum aqui van todos los PERMISOS
 * Se deben de colocar en orden alfabético
 * los permisos pueden ser genericos o especificos
 */
class RolEnum
{

    const ADMINISTRADOR = 'ADMINISTRADOR';

    const USUARIO="USUARIO";

    public static function getConstants() {
        $clase = new ReflectionClass(__CLASS__);
        return $clase->getConstants();
    }

}