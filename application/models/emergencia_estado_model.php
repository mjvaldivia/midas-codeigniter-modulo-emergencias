<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:09 AM
 */
class Emergencia_Estado_Model extends MY_Model
{    
    /**
     * Emergencia terminada
     * @see est_ia_id en tabla estado_emergencia
     */
    const CERRADA = 2;
    
    /**
     * @see tip_ia_id en tabla alertas 
     */
    const EN_CURSO = 1;
            
    /**
     *
     * @var string 
     */
    protected $_tabla = "estados_emergencias";
    
    /**
     * Lista todos los estados
     * @return array
     */
    public function listarTodos(){
         $result = $this->_query->select("*")
                               ->from()
                               ->orderBy("est_c_nombre", "ASC")
                               ->getAllResult();
        if (!is_null($result)){
           return $result; 
        } else {
            return NULL;
        }
    }
    
}