<?php

Class Layout_Rol_Monitor{
    
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
     * Si el usuario es monitor
     * no puede modificar nada
     * @return boolean
     */
    public function puedeEditar(){
        return !$this->usuario->tieneRol(Rol_Model::MONITOR);
    }
}

