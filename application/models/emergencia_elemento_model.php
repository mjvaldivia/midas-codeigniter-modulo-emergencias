<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Elemento_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_elemento";
    
    /**
     * 
     * @param int $id
     * @return int
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return array
     */
    public function getPrimerLugarEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("*")
                       ->whereAND("tipo", "PUNTO LUGAR EMERGENCIA")
                       ->orderBy("id", "ASC")
                       ->limit(1)
                       ->getOneResult();
        if (!is_null($result)){
            return $result; 
        } else {
            return null;
        }
    }
    
    /**
     * 
     * @param array $data
     * @return int
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * @param int $id_emergencia
     * @param array $array
     */
    public function deleteNotIn($id_emergencia, $array){
        $query = $this->_query->select("*")
                               ->from($this->_tabla . "")
                               ->whereAND("id_emergencia", $id_emergencia);
        
        if(count($array)>0){
            $query->whereAND("id", $array, "NOT IN");
        }
        $result = $query->getAllResult();
        
        if (!is_null($result)){
            foreach($result as $row){
                $this->_query->delete("id", $row["id"]);
            }
        }
    }
    
    /**
     * Actualiza 
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id){
        return $this->_query->update($data, "id", $id);
    }
    
    /**
     * Lista por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("*")
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return int
     */
    public function contarPorEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("count(*) as cantidad")
                       ->getOneResult();
        if (!is_null($result)){
           return $result->cantidad; 
        } else {
            return 0;
        }
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return QueryBuilder
     */
    protected function _queryPorEmergencia($id_emergencia){
        $query = $this->_query->from($this->_tabla . "")
                               ->whereAND("id_emergencia", $id_emergencia);
        return $query;
    }
}

