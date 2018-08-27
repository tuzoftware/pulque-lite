<?php

/**
 * Created by PhpStorm.
 * User: Solutions
 * Date: 12/12/2016
 * Time: 06:09 PM
 */
class ValidadorUtil{

    private $validador;
    private $arreglo;

    public function __construct($arreglo){
        $this->arreglo=$arreglo;
        $this->validador=new Valitron\Validator($arreglo);
        Valitron\Validator::addRule('antes', function($field, $value,$params) {
            //Las fechas deben ya venir en formato string
            $fechaUno=DateTime::createFromFormat($params[1], $value);
            $fechaDos=DateTime::createFromFormat($params[1], $params[0]);
            if(!$fechaUno || !$fechaDos){
                return false;
            }
            if($fechaUno<$fechaDos){
                return true;
            }
            return false;
        }, "debe ser una fecha antes de '%s'");
        Valitron\Validator::addRule('despues', function($field, $value,$params) {
            //Las fechas deben ya venir en formato string
            $fechaUno=DateTime::createFromFormat($params[1], $value);
            $fechaDos=DateTime::createFromFormat($params[1], $params[0]);
            if(!$fechaUno || !$fechaDos){
                return false;
            }
            if($fechaUno>$fechaDos){
                return true;
            }
            return false;
        }, "debe ser una fecha posterior a '%s'");
    }


    public function validarFecha($campo,$requerido,$fechaMinima,$fechaMaxima,$formato='Y-m-d'){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule('date',$campo);
        $this->validador->rule('dateFormat', $campo, $formato);
        $this->validador->rule('antes',$campo,$fechaMaxima,$formato);
        $this->validador->rule('despues',$campo,$fechaMinima,$formato);
    }
    public function validarTexto($campo,$requerido,$longitudMinima,$longitudMaxima,$expresionRegular=''){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        if(!empty($expresionRegular)){
            $this->validador->rule('regex',$campo,$expresionRegular);
        }
    }

    public function validarAlfa($campo,$requerido,$longitudMinima,$longitudMaxima){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        $this->validador->rule('alpha', $campo);
    }

    public function validarCorreoElectronico($campo,$requerido,$longitudMinima,$longitudMaxima,$expresionRegular=''){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        $this->validador->rule('email',$campo);
        if(!empty($expresionRegular)){
            $this->validador->rule('regex',$campo,$expresionRegular);
        }
    }

    public function validarNumeroEntero($campo,$requerido,$valorMinimo,$valorMaximo){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule("integer",$campo);
        $this->validador->rule('between', $campo, array($valorMinimo, $valorMaximo));
    }

    public function validarNumero($campo,$requerido,$valorMinimo,$valorMaximo){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule("numeric",$campo);
        $this->validador->rule('between', $campo, array($valorMinimo, $valorMaximo));
    }

    public function validarNumeroId($campo,$requerido,$valorMinimo=1){
        $this->validarRequerido($campo,$requerido);
        $this->validador->rule("numeric",$campo);
        $this->validador->rule('min', $campo,$valorMinimo);
    }

    private function validarRequerido($campo,$requerido){
        if($requerido){
            $this->validador->rule("required",$campo);
        }
    }

    public function validarArregloSimple($requerido,$label){
        if($requerido){
            $this->validador->addRule('arregloRequerido', function($arreglo) {
                if(is_empty($arreglo)){
                    return true;
                }else{
                    return false;
                }
            })->message("El campo $label es requerido");
            $this->validador->rule('arregloRequerido',$this->arreglo);
        }
    }

    public function validarEnumKey($campo,$clase){
        if(!EnumUtil::buscarKey($clase,$this->arreglo[$campo])){
            $mensajes=array($campo=>"Valor no valido");
            MensajeRespuesta::mensajesErrores($mensajes);
        }
    }

    public function validarEnumValue($campo,$clase){
        if(!EnumUtil::buscarValue($clase,$this->arreglo[$campo])){
            $mensajes=array($campo=>array("Valor no valido"));
            MensajeRespuesta::mensajesErrores($mensajes);
        }
    }

    public function validate(){
        return $this->validador->validate();
    }

    public function getErrors(){
        return $this->validador->errors();
    }

    public function agregarEtiquetas($etiquetas){
        $this->validador->labels($etiquetas);
    }

}