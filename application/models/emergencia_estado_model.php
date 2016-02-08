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
    const EN_CURSO = 2;
    
    /**
     * @see tip_ia_id en tabla alertas 
     */
    const EN_ALERTA = 1;


    const FINALIZADA = 3;
            
    /**
     *
     * @var string 
     */
    protected $_tabla = "estados_emergencias";
    
    /**
     * Retorna la alarma por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("est_ia_id", $id);
    }
    
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