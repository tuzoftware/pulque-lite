<?php

class Controller
{
     private $twig;
     protected $f3;
     private $responseArray;
	 protected $data;


	 public function __construct(){
         $this->f3 = \Base::instance();
         $this->twig = $GLOBALS['twig'];//global $twig;
         $this->responseArray=array();
     }

    protected function render($nameHtmlFile){
            echo $this->twig->render($nameHtmlFile,$this->responseArray);
            exit;
     }

    protected function urlParameterName($parameterName){
        return $this->f3->get("PARAMS.".$parameterName);
      }

    protected function post($parameterName){
        return $this->f3->get("POST.".$parameterName);
      }

    protected function get($parameterName){
        return $this->f3->get("GET.".$parameterName);
      }

    protected function base(){
          return $this->f3->get('BASE');
	 }

     protected function response($key,$object){
	     $this->responseArray[$key]=$object;
     }

    public function afterRoute(){
        if ($this->f3->get('EXTEND_TIME') && $this->f3->get('SESSION.id_user')) {
            $this->f3->set('SESSION.time', time());
        }
          /*
          if($this->f3->get('BITACORA')){
              if($this->f3->get('SESSION.id_usuario') && $this->f3->get('AUDITABLE')){
                  //var_dump(F3::hive());
                  //var_dump(current(current(current($this->f3->get('ROUTES')[$this->f3->get('PATTERN')]))));
                  //var_dump($this->f3->get('ROUTES')[$this->f3->get('PATTERN')][3][$this->f3->get('VERB')]);
                  $peticion=$this->f3->get('VERB');
                  $response = implode(",",$this->f3->get($peticion));
                  $ip=$this->f3->get('IP');
                  //$servicio=current(current(current($this->f3->get('ROUTES')[$this->f3->get('PATTERN')])));
                  $metodo=$this->f3->get('PATTERN');
                  $bitacora=new Bitacora();
                  $bitacora->id_usuario=$this->f3->get('SESSION.id_usuario');
                  //$bitacora->servicio=$servicio;
                  $bitacora->parametros=$response;
                  //$bitacora->direccionip=$ip;
                  $bitacora->save();
                  F3::set('AUDITABLE',true);
              }
          }
        */
       }
}