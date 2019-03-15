<?php

/**
 * Created by PhpStorm.
 * User: Solutions
 * Date: 12/12/2019
 * Time: 06:09 PM
 */
class ValidadorUtil{

    private $validator;
    private $array;

    public function __construct($array){
        $this->array=$array;
        $this->validator=new Valitron\Validator($array);
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


    public function validateFecha($campo,$requerido,$fechaMinima,$fechaMaxima,$formato='Y-m-d'){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule('date',$campo);
        $this->validator->rule('dateFormat', $campo, $formato);
        $this->validator->rule('antes',$campo,$fechaMaxima,$formato);
        $this->validator->rule('despues',$campo,$fechaMinima,$formato);
    }
    public function validateText($campo, $requerido, $longitudMinima, $longitudMaxima, $expresionRegular=''){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        if(!empty($expresionRegular)){
            $this->validator->rule('regex',$campo,$expresionRegular);
        }
    }

    public function validateAlfa($campo,$requerido,$longitudMinima,$longitudMaxima){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        $this->validator->rule('alpha', $campo);
    }

    public function validateEmail($campo,$requerido,$longitudMinima,$longitudMaxima,$expresionRegular=''){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule('lengthBetween',$campo, $longitudMinima,$longitudMaxima);
        $this->validator->rule('email',$campo);
        if(!empty($expresionRegular)){
            $this->validator->rule('regex',$campo,$expresionRegular);
        }
    }

    public function validateIntegerNumber($campo,$requerido,$valorMinimo,$valorMaximo){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule("integer",$campo);
        $this->validator->rule('between', $campo, array($valorMinimo, $valorMaximo));
    }

    public function validateNumber($campo,$requerido,$valorMinimo,$valorMaximo){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule("numeric",$campo);
        $this->validator->rule('between', $campo, array($valorMinimo, $valorMaximo));
    }

    public function validateIdNumber($campo,$requerido,$valorMinimo=1){
        $this->validateRequired($campo,$requerido);
        $this->validator->rule("numeric",$campo);
        $this->validator->rule('min', $campo,$valorMinimo);
    }

    private function validateRequired($campo, $requerido){
        if($requerido){
            $this->validator->rule("required",$campo);
        }
    }

    public function validateArregloSimple($requerido,$label){
        if($requerido){
            $this->validator->addRule('arregloRequerido', function($arreglo) {
                if(is_empty($arreglo)){
                    return true;
                }else{
                    return false;
                }
            })->message("El campo $label es requerido");
            $this->validator->rule('arregloRequerido',$this->array);
        }
    }

    public function validateEnumKey($campo,$clase){
        if(!EnumUtil::buscarKey($clase,$this->array[$campo])){
            $mensajes=array($campo=>"Valor no valido");
            ResponseMessage::errorMessages($mensajes);
        }
    }

    public function validateEnumValue($campo,$clase){
        if(!EnumUtil::buscarValue($clase,$this->array[$campo])){
            $mensajes=array($campo=>array("Valor no valido"));
            ResponseMessage::errorMessages($mensajes);
        }
    }

    public function validate(){
        return $this->validator->validate();
    }

    public function getErrors(){
        return $this->validator->errors();
    }

    public function addLabels($labels){
        $this->validator->labels($labels);
    }

}