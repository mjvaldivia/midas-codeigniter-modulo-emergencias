<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Provincia_Model extends MY_Model{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "provincias";
    
    /**
     * Se utiliza emergencias_simulacion o no
     * @var boolean
     */
    protected $_bo_simulacion = false;
    
        /**
     * Lista regiones por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaProvinciasPorEmergencia($id_emergencia){
        $result = $this->_query->select("DISTINCT p.*")
                               ->from($this->_tabla . " p")
                               ->join("comunas c", "c.prov_ia_id = p.prov_ia_id", "INNER")
                               ->join("emergencias_vs_comunas ec", "ec.com_ia_id = c.com_ia_id")
                               ->whereAND("ec.eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }

}