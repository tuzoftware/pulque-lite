<?php
class Autocarga {
	
	function autocargar($dir=null){		
	  $listaDirectorio=glob($dir."/*",GLOB_ONLYDIR);
	  if(count($listaDirectorio)==0){
	   F3::set('AUTOLOAD',F3::get('AUTOLOAD').';'.$dir.'/');
	   return;
	  }
	  foreach($listaDirectorio as $file){
	    $this->autocargar($file);
     }
   }
   
   
	function autocargarTwig($dir){	
     $Directory = new RecursiveDirectoryIterator($dir);
     $Iterator = new RecursiveIteratorIterator($Directory);
     $Regex = new RegexIterator($Iterator, '/^.+(.html?g|.html)$/i', RecursiveRegexIterator::GET_MATCH);
     $rutas=array();
     foreach($Regex as $name => $Regex){
	   $pos=strrpos( $name,  DIRECTORY_SEPARATOR);
       $rutas[]= substr($name, 0,$pos+1);
      }
      return array_unique($rutas);
    }
}