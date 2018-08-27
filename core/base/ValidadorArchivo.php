<?php

class ValidadorArchivo
{
   
   static function validar($file,$name,$size,$extensiones){
    $mensajes=array($name=>array());
    $extension=pathinfo( $file["name"],PATHINFO_EXTENSION);
    $tieneErrores=false;
     if($file["size"] > $size) {
        $mensajes[$name][]="El archivo supera el tamaño maximo";
        $tieneErrores=true;
      }
      $extensionEncontrada=false;
      foreach($extensiones as $extensionAux ){
          if($extensionAux==$extension){
             $extensionEncontrada=true;
              break;
          }
      }
      if(!$extensionEncontrada){
          $tieneErrores=true;
          $mensajes[$name][]="Extension o Tipo de Archivo Invalido";
      }
      if($tieneErrores){
            MensajeRespuesta::mensajes($mensajes,"ERROR");
      }
   }
}