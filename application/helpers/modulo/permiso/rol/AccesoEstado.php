<?php

Class Permiso_Rol_AccesoEstado{
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;

    /**
     *
     * @var Permiso_Model 
     */
    protected $_permiso_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("permiso_model");

        $this->_permiso_model = New Permiso_Model();
    }
    
    /**
     * 
     * @param int $id_rol
     * @return string
     */
    public function render($id_rol){
        $acceso = $this->_permiso_model->tieneAccesoRol($id_rol);
        if($acceso){
            return "<span class=\"badge green\">Activado</span>";
        } else {
            return "<span class=\"badge red\">Desactivado</span>";
        }
    }
}

