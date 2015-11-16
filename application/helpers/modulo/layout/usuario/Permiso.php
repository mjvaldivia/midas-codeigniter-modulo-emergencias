<?php

Class Layout_Usuario_Permiso{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Usuario 
     */
    protected $usuario;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("usuario");
        $this->_ci->load->model("rol_model");
        $this->usuario = New Usuario();
    }
    
    /**
     * Retorna si el usuario puede ver o no el modulo
     * @param modulo $modulo
     * @return boolean
     */
    public function puedeVer($modulo){
        $this->usuario->setModulo($modulo);
        return $this->usuario->getPermisoVer();
    }
    
    /**
     * Si el usuario es monitor
     * no puede modificar nada
     * @return boolean
     */
    public function puedeEditar($modulo){
        return !$this->usuario->tieneRol(Rol_Model::MONITOR);
    }
}

