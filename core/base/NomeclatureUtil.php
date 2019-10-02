<?php


class NomeclatureUtil
{
    /**
     * pass hello_world return helloWorld if upper HelloWorld
     * @param $str
     * @param bool $upper
     * @return string
     */
    public static function snakeToCamel($str,$upper=false) {
        $str=strtolower($str);
        if($upper){
            return ucfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
        }
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }

    /**
     * pass helloWorld return hello_world if upper HELLO_WORLD
     * @param $str
     * @param bool $upper
     * @return string|string[]|null
     */
    public static function camelToSnake($str,$upper=false) {
        $str = preg_replace('/([a-z])([A-Z])/', "\\1_\\2", $str);
        $str = strtolower($str);
        if($upper){
            $str=strtoupper($str);
        }
        return $str;
    }
    /**
     * pass helloWorld return hello-world
     * @param $str
     * @return string|string[]|null
     */
    public static function camelToKebabCase($str) {
        $str = preg_replace('/([a-z])([A-Z])/', "\\1-\\2", $str);
        $str = strtolower($str);
        $str=strtolower($str);
        return $str;
    }

}