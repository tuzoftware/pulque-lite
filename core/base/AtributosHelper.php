<?php

/**
 * Created by PhpStorm.
 * User: Lenovo Flex
 * Date: 28/03/2016
 * Time: 09:51 PM
 */
class AtributosHelper
{

   static public function copiarAtributos($atributos,$arreglo){
       $nuevoArreglo=array();
       foreach($atributos as $atributo){
         $nuevoArreglo[$atributo]=$arreglo[$atributo];
       }
       return $nuevoArreglo;
   }

   static public function establecerAtributos($arreglo,&$arregloDestino){
       if(is_array($arreglo)){
           foreach ($arreglo as $key=>$value){
               $arregloDestino[$key]=$value;
           }
       }
   }

}