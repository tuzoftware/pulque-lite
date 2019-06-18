<?php

/**
 * Created by PhpStorm.
 * User: Solutions
 * Date: 12/12/2019
 * Time: 06:09 PM
 */
class ValidatorUtil{

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


    public function validateFecha($field,$required,$fechaMinima,$fechaMaxima,$formato='Y-m-d'){
        $this->validateRequired($field,$required);
        $this->validator->rule('date',$field);
        $this->validator->rule('dateFormat', $field, $formato);
        $this->validator->rule('antes',$field,$fechaMaxima,$formato);
        $this->validator->rule('despues',$field,$fechaMinima,$formato);
    }
    public function validateText($field, $required, $longitudMinima, $longitudMaxima, $expresionRegular=''){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $longitudMinima,$longitudMaxima);
        if(!empty($expresionRegular)){
            $this->validator->rule('regex',$field,$expresionRegular);
        }
    }

    public function validateAlfa($field,$required,$longitudMinima,$longitudMaxima){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $longitudMinima,$longitudMaxima);
        $this->validator->rule('alpha', $field);
    }

    public function validateEmail($field,$required,$longitudMinima,$longitudMaxima,$expresionRegular=''){
        $this->validateRequired($field,$required);
        $this->validator->rule('lengthBetween',$field, $longitudMinima,$longitudMaxima);
        $this->validator->rule('email',$field);
        if(!empty($expresionRegular)){
            $this->validator->rule('regex',$field,$expresionRegular);
        }
    }

    public function validateIntegerNumber($field,$required,$minValue,$maxValue){
        $this->validateRequired($field,$required);
        $this->validator->rule("integer",$field);
        $this->validator->rule('between', $field, array($minValue, $maxValue));
    }

    public function validateNumber($field,$required,$minValue,$maxValue){
        $this->validateRequired($field,$required);
        $this->validator->rule("numeric",$field);
        $this->validator->rule('between', $field, array($minValue, $maxValue));
    }

    public function validateIdNumber($field,$required,$minValue=1){
        $this->validateRequired($field,$required);
        $this->validator->rule("numeric",$field);
        $this->validator->rule('min', $field,$minValue);
    }

    private function validateRequired($field, $required){
        if($required){
            $this->validator->rule("required",$field);
        }
    }

    public function validateArregloSimple($required,$label){
        if($required){
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

    public function validateEnumKey($field,$class){
        if(!EnumUtil::buscarKey($class,$this->array[$field])){
            $mensajes=array($field=>"Valor no valido");
            ResponseMessage::errorMessages($mensajes);
        }
    }

    public function validateEnumValue($field,$class){
        if(!EnumUtil::buscarValue($class,$this->array[$field])){
            $mensajes=array($field=>array("Valor no valido"));
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