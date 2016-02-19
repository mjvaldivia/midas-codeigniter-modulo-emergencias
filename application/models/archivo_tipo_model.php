<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Archivo_Tipo_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "archivo_tipo";
    
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("id", $id);
    }
    
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar(){
        $query = $this->_query->select("a.*")
                              ->from($this->_tabla . " a")
                              ->orderBy("a.nombre", "ASC");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

