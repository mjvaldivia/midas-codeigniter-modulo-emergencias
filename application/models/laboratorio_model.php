<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Laboratorio_Model extends MY_Model
{    
        
    
    const LOS_RIOS = 4;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "laboratorio";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var type 
     */
    protected $_bo_simulacion = false;
    
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
     * @param string $nombre
     * @return object
     */
    public function getByName($nombre){
        return $this->_query->getById("nombre", $nombre);
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
     * Lista
     * @param array $parametros
     * @return array
     */
    public function listar($parametros = array()){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a")
                               ->orderBy("nombre", "DESC");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
}

