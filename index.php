<?php

// Kickstart the framework
require 'vendor/autoload.php';
$f3 = \Base::instance();

/*
    |--------------------------------------------------------------------------
    | Configuracion GENERAL
    |--------------------------------------------------------------------------
*/
$f3->set('ENCODING','UTF-8');
$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
	trigger_error('PCRE version is out of date');

/*
    |--------------------------------------------------------------------------
    | Archivos de configuracion
    |--------------------------------------------------------------------------
*/
F3::config('config.ini');
F3::config('datasource.ini');
date_default_timezone_set('America/Mexico_City');

/*
    |--------------------------------------------------------------------------
    | Configuracion de Autoload
    |--------------------------------------------------------------------------
*/
$f3->AUTOLOAD="core/lib/Autocarga/;core/lib/F3Access/;core/base/;
core/lib/error/;core/lib/;";
$autocarga = new Autocarga();
$autocarga->autocargar('app');

/*
    |--------------------------------------------------------------------------
    | Configuracion de Twig Plantillas
    |--------------------------------------------------------------------------
*/

$loader = new Twig_Loader_Filesystem($autocarga->autocargarTwig('ui/modules'));

$twig = new Twig_Environment($loader, array(
    'cache' => 'tmp',
    'debug' => true,
    'auto_reload' => true
));
$filter =new Twig_Filter('f3','F3::get');
$twig->addFilter($filter);
$twig->addGlobal('is_ajax',F3::get('AJAX'));
$twig->addGlobal("base", F3::get('BASE'));
$twig->addGlobal("debug", F3::get('DEBUG'));
$functionSeguridad = new Twig_SimpleFunction('tieneAlgunPermiso', function ($permiso) {
    return Seguridad::tieneAlgunPermiso($permiso);
});
$twig->addFunction($functionSeguridad);
$lexer = new Twig_Lexer($twig, array(
    'tag_comment'   => array('[#', '#]'),
    'tag_block'     => array('[%', '%]'),
    'tag_variable'  => array('[[', ']]'),
    'interpolation' => array('#[', ']'),
));
$twig->setLexer($lexer);

$f3->set('twig',$twig);

/*
    |--------------------------------------------------------------------------
    | Configuracion de Errores
    |--------------------------------------------------------------------------
*/
/*
$whoops = new \Whoops\Run;
$whoops->pushHandler(function ($exception) {
    $datetime = new DateTime();
    $folio=' FOLIO '.$datetime->format('dmYhis');
    $logger = new Log('folio.log');
    $mensaje=$exception->getMessage()." ".$exception->getFile()." - ".$exception->getLine().$folio;
    $errorInesperado="Ha ocurrido un Error Inseperado ".$folio;
    $datosAdicionales=array("codigo"=>500,"folio"=>$errorInesperado,"mensaje"=>$mensaje);
    $logger->write($mensaje);
    if(\Whoops\Util\Misc::isAjaxRequest()){
        http_response_code(500);
        MensajeRespuesta::mensajeDatosAdicionales($errorInesperado,$datosAdicionales,'ERROR',500);
    }else{
        F3::error("500",$errorInesperado."|".$mensaje);
    }
});
$whoops->register();
$f3->set('ONERROR','ErrorController->index');
$f3->route('POST /error','ErrorController->indexJSON');
*/
/*
    |--------------------------------------------------------------------------
    | Conexion a la base de datos
    |--------------------------------------------------------------------------
*/
//F3::set('DB',new DB\SQL('mysql:host='.F3::get('localhost').';port='.F3::get('port').';dbname='.F3::get('dbname') ,F3::get('user'),F3::get('password')));
/*
    |--------------------------------------------------------------------------
    | Valitron
    |--------------------------------------------------------------------------
*/
use Valitron\Validator as V;

V::langDir(__DIR__.'/core/lib/Valitron/lang'); // always set langDir before lang.
V::lang('es');

/*
    |--------------------------------------------------------------------------
    | Configuracion de Rutas
    |--------------------------------------------------------------------------
*/
//RUTAS GLOBALES

//RUTAS LOCALES

$f3->route('GET /','HelloController->index');
$f3->run();
