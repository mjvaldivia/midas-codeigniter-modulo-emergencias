<?php

require_once(__DIR__ . "/Emergencia_email_abstract.php");


Class Emergencia_email_revision extends Emergencia_email_abstract{
    
    /**
     *
     * @var boolean 
     */
    protected $_enviar = true;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->_ci->load->model("emergencia_estado_model");
        $this->_ci->load->library("session");
    }
    
    /**
     * 
     * @param int $id
     */
    public function setEmergencia($id){
        parent::setEmergencia($id);
        if($this->_emergencia->est_ia_id != Emergencia_Estado_Model::EN_ALERTA){
            $this->_enviar = false;
        }
    }
    
    /**
     * Si el correo es enviado o no
     * @return boolean
     */
    public function boSeEnviaEmail(){
        return $this->_enviar;
    }
    
     /**
     * Envia correo
     * @return boolean si ocurrio un error o no al enviar
     */
    public function enviar(){
        if($this->_enviar){
           return parent::enviar();
        } else {
           return false;
        }
    }
    
    /**
     * 
     * @return string
     */
    protected function _getSubject(){
        return $this->_simulacion . "EMERGENCIAS: Revisión de Evento";
    }
    
     /**
     * 
     * @return string
     */
    protected function _getCabeceraMensaje(){
        $mensaje = "<b>EMERGENCIAS: Revisión de Evento</b><br><br>";
        $mensaje .= $this->_ci->session->userdata('session_nombres') . " ha registrado la alarma código : " . $this->_emergencia->eme_ia_id . "<br><br>"; 
        return $mensaje;
    }
}

