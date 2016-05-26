<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Kml_Elemento_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_mapa_archivo_elemento";
    
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
     * @return int
     */
    public function insert($data){
        return $this->_query->insert($data);
    }
    
    /**
     * Lista 
     * @param int $id_kml
     * @return array
     */
    public function listaPorKml($id_kml){
        $result = $this->_query->select("*")
                               ->from($this->_tabla)
                               ->whereAND("id_kml", $id_kml)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}

