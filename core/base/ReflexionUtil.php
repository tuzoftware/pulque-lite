<?php

class ReflexionUtil{


  static function obtenerPropiedad($arreglo,$propiedad){
    $reflectionProperty = new ReflectionProperty($arreglo,$propiedad);
    $reflectionProperty->setAccessible(true);
    return $reflectionProperty->getValue($arreglo);
  }

}