<?php

class Enviroment{
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
        $this->_session = New CI_Session();
    }
    
    /**
     * 
     * @return boolean
     */
    public function esSimulacion(){
        $enviroment = $this->_session->userdata('session_enviroment');
        if($enviroment === false){
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * Retorna el environment de la database
     * @return string
     */
    public function getDatabase(){
        $enviroment = $this->_session->userdata('session_enviroment');
        if($enviroment === false){
            return ENVIRONMENT;
        } else {
            return $enviroment;
        }
    }
    
    /**
     * Inicia el ambiente de simulacion
     */
    public function setSimulacion(){
        $this->_session->set_userdata("session_enviroment", "simulacion");
    }
    
    /**
     * Cierra ambiente de simulacion
     */
    public function clearSimulacion(){
        $this->_session->unset_userdata("session_enviroment");
    }
    
 
}

