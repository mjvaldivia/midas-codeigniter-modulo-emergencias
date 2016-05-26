<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Casos_Febriles_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "casos_febriles";
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    
    /**
     * 
     * @param array $data
     * @return int identificador del registro ingresado
     */
    public function insert($data){
        return $this->_query->insert($data);
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
     * 
     */
    public function delete($id){
        $this->_query->delete("id", $id);
    }
    
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->orderBy("a.id", "DESC");
        
        if(!empty($parametros["region"])){
            $query->whereAND("a.id_region", $parametros["region"]);
        }
        
        if(!empty($parametros["comuna"])){
            $query->whereAND("a.id_comuna", $parametros["comuna"]);
        }
        
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

