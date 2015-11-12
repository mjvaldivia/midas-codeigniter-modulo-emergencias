<?php

class Rol_Model extends MY_Model {
    
    const MONITOR = 44;
    
    /**
     *
     * @var string 
     */
    protected $_tabla = "roles";
    
    /**
     * Retorna por el identificador
     * @param int $id clave primaria
     * @return object
     */
    public function getById($id){
        return $this->_query->getById("rol_ia_id", $id);
    }
}
