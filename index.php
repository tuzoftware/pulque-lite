<?php

// Kickstart the framework
require 'vendor/autoload.php';
$f3 = \Base::instance();

/*
    |--------------------------------------------------------------------------
    | GENERAL CONFIGURATION
    |--------------------------------------------------------------------------
*/
$f3->set('ENCODING','UTF-8');
$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
    trigger_error('PCRE version is out of date');

/*
    |--------------------------------------------------------------------------
    | CONFIGURATION FILES
    |--------------------------------------------------------------------------
*/
$f3->config('config.ini');
if(empty($f3->get('MODE')) || $f3->get('MODE')=='DEV'){
$f3->config('datasource-dev.ini');  
}else{
$f3->config('datasource-prod.ini');	
}

date_default_timezone_set('America/Mexico_City');

/*
    |--------------------------------------------------------------------------
    | A U T O L O A D
    |--------------------------------------------------------------------------
*/

$f3->set('AUTOLOAD',"core/lib/Autoload/;core/lib/F3Access/;core/base/;
core/lib/error/;core/lib/;");
$autoLoad = new AutoLoad();
$autoLoad->autoLoadClasses('app');
/*
    |--------------------------------------------------------------------------
    | T W I G
    |--------------------------------------------------------------------------
*/

$loader=new \Twig\Loader\FilesystemLoader($autoLoad->autoLoadTwig('ui/modules'));
$twig = new \Twig\Environment($loader, array(
    'cache' => 'tmp',
    'debug' => true,
    'auto_reload' => true
));

$filter=new \Twig\TwigFilter('f3','F3::get');
$twig->addFilter($filter);
$twig->addGlobal('is_ajax',$f3->get('AJAX'));
$twig->addGlobal("base", $f3->get('BASE'));
$twig->addGlobal("debug", $f3->get('DEBUG'));
$securityFunction = new \Twig\TwigFunction('hasSomeRol', function ($rol) {
    return Security::hasSomeRol($rol);
});
$twig->addFunction($securityFunction);
$sessionFunction = new \Twig\TwigFunction('session', function ($key) {
    return $_SESSION[$key];
});
$twig->addFunction($sessionFunction);
$lexer = new \Twig\Lexer($twig, array(
    'tag_comment'   => array('[#', '#]'),
    'tag_block'     => array('[%', '%]'),
    'tag_variable'  => array('[[', ']]'),
    'interpolation' => array('#[', ']'),
));
$twig->setLexer($lexer);

$f3->set('twig',$twig);

/*
    |--------------------------------------------------------------------------
    | ERRORS
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
    | DATABASE CONECTION
    |--------------------------------------------------------------------------
*/
//$f3->set('DB',new DB\SQL('mysql:host='.$f3->get('host').';port='.$f3->get('port').';dbname='.$f3->get('dbname') ,$f3->get('user'),$f3->get('password')));
/*
    |--------------------------------------------------------------------------
    | V A L I T R O N
    |--------------------------------------------------------------------------
*/
use Valitron\Validator as V;

V::langDir(__DIR__.'/vendor/vlucas/valitron/lang/'); // always set langDir before lang.
V::lang('es');


/*
    |--------------------------------------------------------------------------
    | R O U T E S
    |--------------------------------------------------------------------------
*/
//GLOBAL ROUTES

//LOCAL ROUTES SECURITY

$f3->route('GET /','HelloController->index');
$f3->run();
