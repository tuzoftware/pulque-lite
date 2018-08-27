<?php
class Seguridad{
/*Los roles deben ser iguales a los de sesion*/
 static function tieneAlgunPermiso($permisos){

    

     if(is_array($permisos) && is_array(F3::get('SESSION.permiso'))){
         foreach ($permisos as $permiso) {
		   if(array_search($permiso,F3::get('SESSION.permiso'))!==false){
		     return true;
		   }
		}
	 }else if(is_array($permisos) && !is_array(F3::get('SESSION.permiso'))){

           if(array_search(F3::get('SESSION.permiso'),$permisos)!==false){
		     return true;
		   }else{
		     return false;
		   }
	 }else if(!is_array($permisos) && is_array(F3::get('SESSION.permiso'))){
         if(array_search($permisos,F3::get('SESSION.permiso'))!==false){

		      return true;
		   }else{
             //echo "no entra";
		     return false;
		   }
	 }else{
           if(F3::get('SESSION.permiso')==$permisos){
	         return true;
		   }
	 }
	 return false;
 }
/*Los roles deben ser iguales a los de sesion*/
 static function tienePermisos($pemisos){
     if(is_array($pemisos) && is_array(F3::get('SESSION.permiso'))){
		 $diferenciaUno = array_diff($pemisos, F3::get('SESSION.permiso'));
		 $diferenciaDos = array_diff(F3::get('SESSION.permiso'), $pemisos);
		 if(count($diferenciaUno)==0 && count($diferenciaDos)==0){
		   return true;
		 }
	 }else if(!is_array($pemisos) && !is_array(F3::get('SESSION.permiso'))){
           if(F3::get('SESSION.permiso')==$pemisos){
	         return true;
		   }
	 }
	 return false;
 }

 static function noTienePermiso($roles){

 }

}