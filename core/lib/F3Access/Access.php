<?php

class Access{

  static function permit($route, $controller, $roles){
      if(Security::hasAnyRol($roles)){
          F3::route($route,$controller);
      }
  }

}
