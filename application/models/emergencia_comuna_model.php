<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Emergencia_Comuna_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_vs_comunas";
        
    
    /**
     * Lista de provincias por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaRegionesPorEmergencia($id_emergencia){
        $result = $this->_query->select("DISTINCT r.*")
                               ->from($this->_tabla . " ec")
                               ->join("comunas c", "c.com_ia_id = ec.com_ia_id", "INNER")
                               ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                               ->join("regiones r", "r.reg_ia_id = p.reg_ia_id", "INNER")
                               ->whereAND("eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    
    /**
     * Lista de provincias por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaProvinciasPorEmergencia($id_emergencia){
        $result = $this->_query->select("DISTINCT p.*")
                               ->from($this->_tabla . " ec")
                               ->join("comunas c", "c.com_ia_id = ec.com_ia_id", "INNER")
                               ->join("provincias p", "p.prov_ia_id = c.prov_ia_id", "INNER")
                               ->whereAND("eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return array
     */
    public function listaComunasPorEmergencia($id_emergencia){
        $result = $this->_query->select("ec.evc_ia_id, c.com_ia_id, c.com_c_nombre")
                               ->from($this->_tabla . " ec")
                               ->join("comunas c", "c.com_ia_id = ec.com_ia_id", "INNER")
                               ->whereAND("eme_ia_id", $id_emergencia)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
}
