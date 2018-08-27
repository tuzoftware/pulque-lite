<?php

class DebugUtils{
	
	static public function escribirLog($cadena){
		$logger = new Log('folio.log');
        $logger->write($cadena);
	}
	
	static public function varDump($variable){
		echo "<pre>";
		var_dump($variable);
		echo "</pre>";
	}
	
	
}