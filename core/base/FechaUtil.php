<?php

class FechaUtil{

    public static function validarFecha($date, $format = 'd/m/Y'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Convierte una fec
     * @param $fecha
     * @param string $format
     * @return false|string
     */
    public static function convertirFecha($fecha, $formatoOrigen = "d/m/Y", $formatoDestino = 'Y-m-d'){
        $fecha = DateTime::createFromFormat($formatoOrigen, $fecha);
        return $fecha->format($formatoDestino);
    }

    /**
     * Convierte un campo de un arreglo por referencia
     * @param $arreglo
     * @param $keyFecha
     * @param string $formatoOrigen
     * @param string $formatoDestino
     */
    public static function convertirFechaReferencia(&$arreglo, $keyFecha, $formatoOrigen = "d/m/Y", $formatoDestino = 'Y-m-d'){
        if(!empty($arreglo) && array_key_exists($keyFecha,$arreglo) && !empty($arreglo[$keyFecha])){
            $fecha = DateTime::createFromFormat($formatoOrigen, $arreglo[$keyFecha]);
            $arreglo[$keyFecha]=$fecha->format($formatoDestino);
        }
    }

    /**
     * Retorna un objeto DateTime a partir de un formato ya creado
     * @param $fecha
     * @param string $formatoOrigen
     * @return bool|DateTime
     */
    public static function crearFechaFormato($fecha, $formatoOrigen = "d/m/Y"){
        $fecha = DateTime::createFromFormat($formatoOrigen, $fecha);
        return $fecha;
    }

    /**
     * Agrega un intervalo Dias, Anios a una fecha con formato String
     * @param $fecha
     * @param string $intervalo
     * @param string $formato
     * @return string
     */
    public static function agregarIntervaloFechaStr($fecha, $intervalo='P1D', $formato = 'Y-m-d'){
        $fecha = DateTime::createFromFormat($formato, $fecha);
        $fecha->add(new DateInterval($intervalo));
        return $fecha->format($formato);
    }

}