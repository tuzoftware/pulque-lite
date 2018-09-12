<?php

class ReflexionUtil{


  static function getProperty($array, $property){
    $reflectionProperty = new ReflectionProperty($array,$property);
    $reflectionProperty->setAccessible(true);
    return $reflectionProperty->getValue($array);
  }

}