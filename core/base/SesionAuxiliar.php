<?php

class SesionAuxiliar
{
	static function subir($identificador,$objeto){
	    global $twig;
		F3::set('SESSION.'.$identificador,$objeto);
		$twig->addGlobal("session", F3::get('SESSION'));
	}
	
	static function obtener($identificador){
	   return F3::get('SESSION.'.$identificador);
	}
	
	static function eliminar($identificador){
	   global $twig;
	   F3::set('SESSION.'.$identificador,null);
	   $twig->addGlobal("session", F3::get('SESSION'));
	}
	

}