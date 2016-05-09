<?php

Class Usuario{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    /**
     *
     * @var Modulo_Model 
     */
    protected $_modulo_model;
    
    /**
     *
     * @var Permiso_Model
     */
    protected $_permiso_model;
    
    /**
     *
     * @var int
     */
    protected $_id_modulo;
    
    /**
     * Si es o no administrador
     * @var boolean
     */
    protected $_administrador = false;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
        $this->_ci->load->model("modulo_model");
        $this->_ci->load->model("permiso_model");
        
        $this->_session       = New CI_Session();
        $this->_modulo_model = New Modulo_Model();
        $this->_permiso_model = New Permiso_Model();
    }
    
    /**
     * Setea modulo actual
     * @param string $modulo
     * @throws Exception
     */
    public function setModulo($modulo){
        switch ($modulo) {
            case "alarma":
                $this->_id_modulo = Modulo_Model::SUB_MODULO_ALARMA;
                break;
            case "emergencia":
                $this->_id_modulo = Modulo_Model::SUB_MODULO_EMERGENCIA;
                break;
            case "capas":
                $this->_id_modulo = Modulo_Model::SUB_MODULO_CAPAS;
                break;
            case "simulacion":
                $this->_id_modulo = Modulo_Model::SUB_SIMULACION;
                break;
            case "documentacion":
                $this->_id_modulo = Modulo_Model::SUB_DOCUMENTACION;
                break;
            case "administracion":
                $this->_administrador = true;
                break;
            case "casos_febriles":
                $this->_id_modulo = Modulo_Model::SUB_CASOS_FEBRILES;
                break;
            case "marea_roja":
                $this->_id_modulo = Modulo_Model::SUB_MAREA_ROJA;
                break;
             case "marea_roja":
                $this->_id_modulo = Modulo_Model::SUB_MAREA_ROJA;
                break;
            case "vectores":
                $this->_id_modulo = Modulo_Model::SUB_VECTORES;
                break;
            default:
                throw new Exception("No se encontro el modulo");
                break;
        } 
    }
    
    /**
     * Retorna arreglo con identificadores de roles
     * @return array
     */
    public function listarRoles(){
        $roles = explode(",", $this->_session->userdata("session_roles"));
        return $roles;
    }
    
    /**
     * Verifica si el usuario posee el rol
     * @param int $id_rol
     * @return boolean
     */
    public function tieneRol($id_rol){
        $roles = $this->listarRoles();
        if(array_search($id_rol, $roles) === false){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoFinalizarEmergencia(){
        $permiso = $this->_permiso_model->tienePermisoFinalizarEmergencia($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoReporteEmergencia(){
        $permiso = $this->_permiso_model->tienePermisoReporteEmergencia($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoActivarAlarma(){
        $permiso = $this->_permiso_model->tienePermisoActivarAlarma($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoVisorEmergencia(){
        $permiso = $this->_permiso_model->tienePermisoVisorEmergencia($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Si puede editar o no
     * @return boolean
     */
    public function getPermisoEliminar(){
        $permiso = $this->_permiso_model->tienePermisoEliminar($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Si puede editar o no
     * @return boolean
     */
    public function getPermisoEditar(){
        $permiso = $this->_permiso_model->tienePermisoEditar($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoVerFormularioDatosPersonales(){
        $permiso = $this->_permiso_model->tienePermisoVerFormularioDatosPersonales($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @return boolean
     */
    public function getPermisoEmbarazada(){
        $permiso = $this->_permiso_model->tienePermisoEmbarazadas($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Si tiene o no permisos para ver el modulo
     * @return boolean
     */
    public function getPermisoVer(){
        $permiso = $this->_permiso_model->tieneAccesoModulo($this->listarRoles(), $this->_id_modulo);
        if($permiso){
            return true;
        } else {
            return false;
        }
    }
}

