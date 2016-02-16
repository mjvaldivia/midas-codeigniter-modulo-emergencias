<?php

if (!defined('BASEPATH')){
    exit('No direct script access allowed');
}

/**
 * Alarma Model
 */
class Rapanui_Ebola_Model extends MY_Model {
    
    /**
     * Nombre de tabla
     * @var string 
     */
    protected $_tabla = "rapanui_ebola";
    
    /**
     * Lista alarmas de acuerdo a parametros
     * @param array $parametros
     * @return array
     */
    public function listar(){
        $query = $this->_query->select("a.*")
                               ->from($this->_tabla . " a");
        $result = $query->getAllResult();
        if(!is_null($result)){
            return $result;
        } else {
            return NULL;
        }
    }
}

