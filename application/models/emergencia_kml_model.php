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
}

