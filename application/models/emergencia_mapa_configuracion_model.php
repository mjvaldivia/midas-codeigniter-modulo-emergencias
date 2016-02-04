<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Mapa_Configuracion_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_mapa_configuracion";
    
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
     * @param array $data
     * @return int
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * 
     * @param int $id
     * @param array $data
     * @return int
     */
    public function update($id, $data){
        return $this->_query->update($data, "id", $id );
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @param array $data
     * @return type
     */
    public function updatePorEmergencia($id_emergencia, $data){
        return $this->_query->update($data, "id_emergencia", $id_emergencia );
    }
    
    /**
     * 
     * @param int $id_emergencia
     * @return array
     */
    public function getByEmergencia($id_emergencia){
        $result = $this->_queryPorEmergencia($id_emergencia)
                       ->select("*")
                       ->getOneResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
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
