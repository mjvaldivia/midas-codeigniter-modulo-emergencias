<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Capas_Geometria_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_capa";
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaPorEmergencia($id_emergencia){
        $result = $this->_query->select("cg.*")
                               ->from($this->_tabla . " cg")
                               ->join("capas_geometria g", "g.geometria_id = cg.id_geometria")
                               ->join("capas c", "c.cap_ia_id = g.geometria_capa", "INNER")
                               ->whereAND("cg.id_emergencia", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}

