<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Emergencia_Comuna_Model extends MY_Model
{    
        
    /**
     *
     * @var string 
     */
    protected $_tabla = "emergencias_vs_comunas";
    
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return string
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
