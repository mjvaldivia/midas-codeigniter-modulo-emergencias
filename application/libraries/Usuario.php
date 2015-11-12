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
    protected $session;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
        $this->session = New CI_Session();
    }
    
    /**
     * Verifica si el usuario posee el rol
     * @param int $id_rol
     * @return boolean
     */
    public function tieneRol($id_rol){
        $roles = explode(",", $this->session->userdata("session_roles"));
        if(array_search($id_rol, $roles) === false){
            return false;
        } else {
            return true;
        }
    }
}

