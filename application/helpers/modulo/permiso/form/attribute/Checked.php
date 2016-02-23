<?php

Class Permiso_Form_Attribute_Checked{
    
    protected $_id_rol;
    
    protected $_id_modulo;
    
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
     * @var Modulo_Model 
     */
    protected $_modulo_model;
    
    /**
     *
     * @var Rol_Model
     */
    protected $_rol_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("permiso_model");

        $this->_permiso_model = New Permiso_Model();
        $this->_modulo_model  = New Modulo_Model();
        $this->_rol_model     = New Rol_Model();
    }
    
    /**
     * 
     * @param int $id_rol
     */
    public function setRol($id_rol){
        $this->_id_rol = $id_rol;
    }
    
    /**
     * 
     * @param int $id_permiso
     */
    public function setModulo($id_modulo){
        $this->_id_modulo = $id_modulo;
    }
    
    /**
     * 
     * @return string
     */
    public function finalizar(){
        $valido = $this->_permiso_model->tienePermisoFinalizarEmergencia(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function editar(){
        $valido = $this->_permiso_model->tienePermisoEditar(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function eliminar(){
        $valido = $this->_permiso_model->tienePermisoEliminar(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function ver(){
        $valido = $this->_permiso_model->tieneAccesoModulo(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function reporteEmergencia(){
        $valido = $this->_permiso_model->tienePermisoReporteEmergencia(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function visorEmergencia(){
        fb($this->_id_rol . " " . $this->_id_modulo);
        $valido = $this->_permiso_model->tienePermisoVisorEmergencia(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    public function activarAlarma(){
        $valido = $this->_permiso_model->tienePermisoActivarAlarma(array($this->_id_rol), $this->_id_modulo);
        if($valido){
            return $this->_checked();
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @return string
     */
    protected function _checked(){
        return "checked=\"checked\"";
    }
}