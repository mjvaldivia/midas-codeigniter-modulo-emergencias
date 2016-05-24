<?php

Class Permiso{
    
    protected $_ci;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance(); 
        $this->_ci->load->library("core/usuario/usuario_permiso");
    }
    
    /**
     * Ve si el permiso existe
     * @param string $accion
     * @return boolean
     */
    public function permiso($accion, $id_usuario){
        return $this->_ci->usuario_permiso->permiso(
            Modulo_Model::SUB_CASOS_FEBRILES,
            $accion,
            $id_usuario
        );
    }
}

