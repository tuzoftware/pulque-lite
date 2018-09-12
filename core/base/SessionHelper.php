<?php

class SessionHelper{

    /**Set in sesion the key and the value
     * @param $key
     * @param $value
     */
	static function set($key,$value){
        $f3 = \Base::instance();
		$f3->set('SESSION.'.$key,$value);
	}

    /**Get from session the value or object,
     * @param $key
     * @return mixed null if is not found
     */
	static function get($key){
        $f3 = \Base::instance();
        return $f3->get('SESSION.'.$key);
	}

    /** Delete from session the key
     * @param $key
     */
	static function delete($key){
        $f3 = \Base::instance();
        $f3->set('SESSION.'.$key,null);
	}

}