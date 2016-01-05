<?php

class Modulo_Model extends MY_Model {
    
    const MODULO_EMERGENCIA = 2;
    
    
    /**
     * Modulos del sistema
     */
    const SUB_MODULO_ALARMA = 6;
    const SUB_MODULO_EMERGENCIA = 7;
    const SUB_MODULO_CAPAS = 41;
    const SUB_SIMULACION   = 42;
    const SUB_DOCUMENTACION = 43;

    /**
     *
     * @var string 
     */
    protected $_tabla = "permisos";
    
    /**
     * 
     * @return array
     */
    public function listarModulosEmergencia(){
        $result = $this->_query->select("*")
                               ->from()
                               ->whereAND("per_c_id_modulo", Modulo_Model::MODULO_EMERGENCIA)
                               ->orderBy("per_c_nombre", "ASC")
                               ->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
    
    /**
     * Lista los submodulos de emergencia
     * @return array
     */
    public function listSubmodulos(){
        $array = array(Modulo_Model::SUB_MODULO_ALARMA,
                       Modulo_Model::SUB_MODULO_EMERGENCIA,
                       Modulo_Model::SUB_MODULO_CAPAS,
                       Modulo_Model::SUB_SIMULACION,
                       Modulo_Model::SUB_DOCUMENTACION);
        return $array;
    }
}

