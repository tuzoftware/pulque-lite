<?php

/**
 * Created by PhpStorm.
 * User: ULTRABOOK
 * Date: 07/12/2016
 * Time: 01:24 PM
 */
class Repository
{
    protected $db;
    protected $filtros;
    protected $sql;

    public function __construct($db='DB')
    {
        $this->db =F3::get($db);
        $this->filtros=array();
    }

    public function obtenerInstanciaBD(){
        return $this->db;
    }

    public function beginTransacction(){
        $this->db->begin();
    }

    public function commitTransaction(){
        return $this->db->commit();
    }

    public function rollBackTransaction(){
        $this->db->rollback();
    }

    public function obtenerInstancia($nombre_tabla){
        return new DB\SQL\Mapper($this->db,$nombre_tabla);
    }

    public function obtenerInstanciaIdValor($nombre_tabla,$id,$valor){
        $objeto=new DB\SQL\Mapper($this->db,$nombre_tabla);
        $objeto->load(array($id.'=?',$valor));
        return $objeto;
    }

    public function obtenerCampoValor($nombre_tabla,$campo,$valor,$key){
        $objeto=new DB\SQL\Mapper($this->db,$nombre_tabla);
        $objeto->load(array($campo.'=?',$valor));
        return $objeto[$key];
    }

    public function eliminarInstanciaIdValor($nombre_tabla,$id,$valor){
            $objeto=new DB\SQL\Mapper($this->db,$nombre_tabla);
            $objeto->load(array($id.'=?',$valor));
            $objeto->erase();
    }

    public function existeValor($nombreTabla, $nombreIdForanea,$valorForanea, $nombreCampo, $valor){
        $tabla=new DB\SQL\Mapper($this->db,$nombreTabla);
        $filtro=array("$nombreIdForanea=? AND $nombreCampo=?",$valorForanea,$valor);
        $tabla->load($filtro);
        $existe=false;
        if(empty($tabla[$nombreIdForanea])){
            $existe=false;
        }else{
            $existe=true;
        }
        return $existe;
    }

    public function existeId($nombre_tabla,$id,$valor){
        $objeto=new DB\SQL\Mapper($this->db,$nombre_tabla);
        $objeto->load(array($id.'=?',$valor));
        $existe=false;
        if(!empty($objeto[$id])){
            $existe=true;
        }
        return $existe;
    }

    public function existeGuardarEditarNombreCampo($nombre_tabla,$arreglo,$nombreCampo,$nombreId){
        $objeto=new DB\SQL\Mapper($this->db,$nombre_tabla);
        $existe=false;
        if(empty($arreglo[$nombreId])){
            $objeto->load(array($nombreCampo.'=?',$arreglo[$nombreCampo]));
        }else{
            $objeto->load(array($nombreCampo.'=? AND '.$nombreId.'!=?',$arreglo[$nombreCampo],$arreglo[$nombreId]));
        }
        if(!empty($objeto[$nombreId])){
            $existe=true;
        }
        return $existe;
    }

    protected function actualizacion(){
        $resultados=array();
        $resultados=$this->db->exec($this->sql,$this->filtros);
        $this->filtros=array();
        if(empty($resultados)){
            return false;
        }
        return $resultados;
    }


    protected function resultado(){
        $resultados=array();
        $resultados=$this->db->exec($this->sql,$this->filtros);
        $this->filtros=array();
        if(empty($resultados)){
            return false;
        }
        return $resultados;
    }

    protected function renglon(){
        $resultados=$this->db->exec($this->sql,$this->filtros);
        $this->filtros=array();
        if(empty($resultados)){
            return false;
        }
        return $resultados[0];
    }

    protected function escalar(){
        $resultados=$this->db->exec($this->sql,$this->filtros);
        $this->filtros=array();
        if(empty($resultados)){
            return false;
        }
        return current($resultados[0]);
    }

    public function convertirArregloModelo($nombreTabla,$arreglo){
        $objeto = null;
        if($arreglo!=null || count($arreglo)!=0){
            $objeto = new DB\SQL\Mapper($this->db,$nombreTabla);
            foreach ($arreglo as $key => $value) {
                $objeto->$key = $this->limpiar($value);
            }
        }
        return $objeto;
    }

    public function guardar(&$arreglo,$nombre_tabla){
        $objeto=$this->convertirArregloModelo($nombre_tabla,$arreglo);
        $objeto->save();
        $arreglo=$objeto;
    }

    public function actualizar(&$arreglo,$nombre_tabla,$id){
        $objeto=$this->copiarPropiedades($arreglo,$nombre_tabla,$id);
        $objeto->update();
        $arreglo=$objeto;
    }

    public function guardarActualizar($arreglo,$nombre_tabla,$id){
        $objeto=null;
        if(empty($arreglo[$id])){
            $objeto=$this->convertirArregloModelo($nombre_tabla,$arreglo);
            $objeto->save();
        }else{
            $objeto=$this->copiarPropiedades($arreglo,$nombre_tabla,$id);
            $objeto->update();
        }
        return $objeto;
    }

    private function copiarPropiedades($arreglo,$nombre_tabla,$id){
        $valor=$arreglo[$id];
        $objetoOriginal=$this->obtenerInstanciaIdValor($nombre_tabla,$id,$valor);
        foreach ($arreglo as $key => $value) {
            $objetoOriginal->$key = $this->limpiar($value);
        }
        return $objetoOriginal;
    }

    private function limpiar($valor){
        if(is_string($valor) && F3::get('LIMPIAR')){
            $valor=trim($valor,"");
            switch(F3::get('CAPITALIZAR')){
                case 1:
                    $valor=strtoupper($valor);
                    break;
                case 2:
                    $valor=strtolower($valor);
                    break;
                default:
                    return $valor;
            }
        }
        return $valor;
    }


}