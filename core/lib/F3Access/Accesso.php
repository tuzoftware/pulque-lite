<?php

class Accesso{

  static function permitir($ruta,$controlador,$permisos){
      if(Seguridad::tieneAlgunPermiso($permisos)){
          F3::route($ruta,$controlador);
      }
  }

}
