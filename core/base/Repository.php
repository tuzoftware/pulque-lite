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
    protected $filters;
    protected $sql;

    public function __construct($db='DB')
    {
        $f3 = \Base::instance();
        $this->db =$f3->get($db);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->filters=array();
    }

    public function getInstanceBD(){
        return $this->db;
    }

    public function beginTransaction(){
        $this->db->begin();
    }

    public function commitTransaction(){
        return $this->db->commit();
    }

    public function rollBackTransaction(){
        $this->db->rollback();
    }

    public function getInstance($tableName){
        return new DB\SQL\Mapper($this->db,$tableName);
    }

    public function getInstanceIdValue($tableName, $idName, $value){
        $object=new DB\SQL\Mapper($this->db,$tableName);
        $object->load(array($idName.'=?',$value));
        return $object;
    }

    public function getFieldByFieldValue($tableName, $fieldName, $value, $fieldNameToReturn){
        $object=new DB\SQL\Mapper($this->db,$tableName);
        $object->load(array($fieldName.'=?',$value));
        return $object[$fieldNameToReturn];
    }

    public function deleteInstanceByIdValue($tableName, $idName, $value){
        $object=new DB\SQL\Mapper($this->db,$tableName);
        $object->load(array($idName.'=?',$value));
        $object->erase();
    }

    public function existOnlyValue($tableName, $fieldName, $fieldValue){
        $table=new DB\SQL\Mapper($this->db,$tableName);
        $filter=array("$fieldName=?",$fieldValue);
        $table->load($filter);
        if(empty($table[$fieldName])){
            $exist=false;
        }else{
            $exist=true;
        }
        return $exist;
    }

    public function existValue($tableName, $idForeignKeyName, $foreignValue, $fieldName, $value){
        $table=new DB\SQL\Mapper($this->db,$tableName);
        $filter=array("$idForeignKeyName=? AND $fieldName=?",$foreignValue,$value);
        $table->load($filter);
        if(empty($table[$idForeignKeyName])){
            $exist=false;
        }else{
            $exist=true;
        }
        return $exist;
    }

    public function existId($tableName, $idName, $value){
        $object=new DB\SQL\Mapper($this->db,$tableName);
        $object->load(array($idName.'=?',$value));
        $exist=false;
        if(!empty($object[$idName])){
            $exist=true;
        }
        return $exist;
    }

    public function existFieldUnique ($tableName, $array, $fieldName, $idName){
        $object=new DB\SQL\Mapper($this->db,$tableName);
        $exist=false;
        if(empty($array[$idName])){
            $object->load(array($fieldName.'=?',$array[$fieldName]));
        }else{
            $object->load(array($fieldName.'=? AND '.$idName.'!=?',$array[$fieldName],$array[$idName]));
        }
        if(!empty($object[$idName])){
            $exist=true;
        }
        return $exist;
    }

    protected function executeSQL(){
        $results=$this->db->exec($this->sql,$this->filters);
        $this->filters=array();
        if(empty($results)){
            return false;
        }
        return $results;
    }


    protected function result(){
        $results=$this->db->exec($this->sql,$this->filters);
        $this->filters=array();
        if(empty($results)){
            return false;
        }
        return $results;
    }

    protected function uniqueResult(){
        $results=$this->db->exec($this->sql,$this->filters);
        $this->filters=array();
        if(empty($results)){
            return false;
        }
        return $results[0];
    }

    protected function scalar(){
        $results=$this->db->exec($this->sql,$this->filters);
        $this->filters=array();
        if(empty($results)){
            return false;
        }
        return current($results[0]);
    }


    public function convertArrayToModel($tableName, $array){
        $object = null;
        if($array!=null || count($array)!=0){
            $object = new DB\SQL\Mapper($this->db,$tableName);
            foreach ($array as $key => $value) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    public function save(&$array, $tableName){
        $object=$this->convertArrayToModel($tableName,$array);
        $object->save();
        $array=$object;
    }

    public function update(&$array, $tableName, $idName){
        $object=$this->copyProperties($array,$tableName,$idName);
        $object->update();
        $array=$object;
    }

    public function saveOrUpdate($array,$table_name,$idName){
        $object=null;
        if(empty($array[$idName])){
            $object=$this->convertArrayToModel($table_name,$array);
            $object->save();
        }else{
            $object=$this->copyProperties($array,$table_name,$idName);
            $object->update();
        }
        return $object;
    }

    private function copyProperties($array, $tableName, $idName){
        $value=$array[$idName];
        $originalObject=$this->getInstanceIdValue($tableName,$idName,$value);
        foreach ($array as $key => $value) {
            $originalObject->$key = $value;
        }
        return $originalObject;
    }


}