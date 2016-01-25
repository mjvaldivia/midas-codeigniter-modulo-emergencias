<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Kml_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_kml";
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    
    
    /**
     * Lista por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_query->select("k.*")
                               ->from($this->_tabla . " k")
                               ->whereAND("k.id_emergencia", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
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
}

