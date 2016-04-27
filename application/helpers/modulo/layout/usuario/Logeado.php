<?php

Class Layout_Usuario_Logeado{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
    }
    
    public function estaLogeado(){
        $sessionId = $this->_ci->session->userdata('session_idUsuario');

        if(empty($sessionId)) {
            return false;
        } else {
            return true;
        }
    }
}

