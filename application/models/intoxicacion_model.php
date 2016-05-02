<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Intoxicacion_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "intoxicaciones";
    
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
    public function listarPorFecha($fecha){
        
        
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->addWhere("FUR", $fecha, "<=")
                               ->addWhere("FPP", $fecha, ">=")
                               ->orderBy("id", "DESC");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar(){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->orderBy("id", "DESC");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

