<?php
class Redireccionador{

  static function redireccionar($location, $asincrona = false)
  {
    //$redireccion = array();
    //$redireccion['redireccion']=true;
    //$redireccion['location']=$location;
    http_response_code(408);
    //header('Content-type: application/json');
    //echo json_encode($location);
    if ($asincrona == false) {
      header("Location:" . $location);
      return;
    } else {
      echo F3::get('BASE') . "/errorSesion";
    }
  }
  

}