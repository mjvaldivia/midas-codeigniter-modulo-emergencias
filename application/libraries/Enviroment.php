<?php

class Enviroment{
    
    /**
     *
     * @var CI_Session 
     */
    protected $_session;
    
    protected $_ci;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->library("session");
    }
    
    /**
     * 
     * @return boolean
     */
    public function esSimulacion(){
        $enviroment = $this->_ci->session->userdata('session_enviroment');
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
        $enviroment = $this->_ci->session->userdata('session_enviroment');
        if($enviroment === false OR $enviroment == ""){
            return ENVIRONMENT;
        } else {
            $retorno = "";
            switch ($enviroment) {
                case "production":
                case "testing":
                case "development":
                case "simulacion":
                    $retorno = $enviroment;
                    break;
                default:
                    $retorno = ENVIRONMENT;
                    break;
            }
            return $retorno;
        }
    }
    
    /**
     * Inicia el ambiente de simulacion
     */
    public function setSimulacion(){
        $this->_ci->session->set_userdata("session_enviroment", "simulacion");
    }
    
    /**
     * Cierra ambiente de simulacion
     */
    public function clearSimulacion(){
        $this->_ci->session->unset_userdata("session_enviroment");
    }
    
 
}

