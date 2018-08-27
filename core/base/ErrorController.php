<?php
class ErrorController extends Controller{

  
  function index(){
	$errorCode=F3::get("ERROR.code");
	$errorText=F3::get("ERROR.text");
    $this->redireccionaError($errorCode,$errorText);
	
  }
  
  function indexJSON(){
	  $errorCode=F3::get('POST.codigo');
	  $errorText=F3::get('POST.folio')."|".F3::get('POST.mensaje');
	  $this->redireccionaError($errorCode,$errorText);
  }
  
  private function redireccionaError($errorCode,$errorText){
	  if($errorCode==408){
         $this->errorSesion();
      }else if($errorCode==404 || $errorCode==403){
          $this->errorNoEncontrada();
      }else{
          $this->error($errorText);
      }
  }
  
  private function error($errorText){
      $this->parametros["codigo"]="500";
      $this->establecerMensajesError($errorText);
      $this->render("error.html");
  }
  
  private function establecerMensajesError($errorText){
	  $errores=explode("|",$errorText);
	  if(count($errores)!=0){
		   $this->parametros["texto"]=$errores[0];
           $this->parametros["traza"]=$errores[1];
	  }
  }
  
  private function errorNoEncontrada(){
      $this->parametros["codigo"]="404";
      $this->parametros["texto"]="Página no encontrada";
      $this->render("error.html");
  }
  
  function errorSesion(){
	  F3::clear('SESSION');
      $this->parametros["codigo"]="408";
      $this->parametros["texto"]="Su sesión ha expirado";
      $this->render("error.html");
  }
  

}