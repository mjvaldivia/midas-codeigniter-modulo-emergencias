<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Archivo_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_archivo";
    
    
    /**
     * Lista por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_query
                       ->from($this->_tabla . " ea")
                       ->join("archivo a", "a.arch_ia_id = ea.id_archivo", "INNER")
                       ->whereAND("id_emergencia", $id_emergencia)
                       ->select("a.*")
                       ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}

