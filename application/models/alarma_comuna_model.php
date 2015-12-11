<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Alarma_Comuna_Model extends MY_Model{    
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "alertas_vs_comunas";
        
    /**
     * Lista de comunas por emergencia
     * @param int $id_emergencia
     * @return string
     */
    public function listaComunasPorAlarma($id_alarma){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("ala_ia_id", $id_alarma)
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }

}
