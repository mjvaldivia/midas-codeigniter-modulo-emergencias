<?php

Class Emergenciaemail{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var Simulacion 
     */
    protected $_simulacion;
    
    /**
     *
     * @var array 
     */
    protected $_emergencia;
    
    /**
     *
     * @var Emergencia_Model 
     */
    protected $_emergencia_model;
    
    /**
     *
     * @var Tipo_Emergencia_Model 
     */
    protected $_emergencia_tipo_model;
    
    /**
     *
     * @var Emergencia_Comuna_model 
     */
    protected $_emergencia_comuna_model;
    
    /**
     *
     * @var Sendmail_Model 
     */
    protected $_sendmail_model;
    
    /**
     * 
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_model");
        $this->_ci->load->model("sendmail_model");
        $this->_ci->load->model("tipo_emergencia_model");
        $this->_ci->load->model("emergencia_comuna_model");
        
        $this->_ci->load->library("simulacion");
        
        $this->_emergencia_model        = New Emergencia_Model();
        $this->_emergencia_tipo_model   = New Emergencia_Estado_Model();
        $this->_emergencia_comuna_model = New Emergencia_Comuna_Model();
        $this->_sendmail_model          = New Sendmail_Model();
        $this->_simulacion = New Simulacion();
    }
    
    /**
     * 
     * @param int $id identificador de la emergencia
     * @throws Exception
     */
    public function setEmergencia($id){
        $this->_emergencia = $this->_emergencia_model->getById($id);
        if(is_null($this->_emergencia)){
            throw new Exception(__METHOD__ . " - La emergencia no existe");
        }
    }
    
    /**
     * Envia correo
     * @return boolean
     */
    public function enviar(){
        $subject = $this->_simulacion . "Confirmación de una situación de emergencia";
        $to = $this->_sendmail_model->get_destinatariosCorreo($this->_emergencia->tip_ia_id, $this->_listaIdComunasConComa(), null);
        return $this->_sendmail_model->emailSend($to, null, null, $subject, $this->_getMensaje(), false);
    }
    
    /**
     * Retorna contenido del email
     * @return string
     */
    protected function _getMensaje(){
        $mensaje = "<b>Confirmación de una situación de emergencia</b><br><br>";
        $mensaje .= "Se ha activado la emergencia código " . $this->_emergencia->eme_ia_id . "<br><br>";
        $mensaje .= "<b>Nombre de la emergencia:</b> " . $this->_emergencia->eme_c_nombre_emergencia . "<br>";
        $mensaje .= "<b>Tipo de emergencia:</b> " . $this->_getNombreTipo() . "<br>";
        $mensaje .= "<b>Lugar o dirección de la emergencia:</b> " . $this->_emergencia->eme_c_lugar_emergencia . "<br>";
        $mensaje .= "<b>Comuna(s):</b> " . $this->_listaNombreComunasConComa() . "<br>";
        $mensaje .= "<b>Fecha de la emergencia:</b> " . spanishDateToISO($this->_emergencia->eme_d_fecha_emergencia) . "<br>";
        $mensaje .= "<b>Fecha recepción de la emergencia:</b> " . spanishDateToISO($this->_emergencia->eme_d_fecha_recepcion) . "<br>";
        $mensaje .= "<b>Nombre del informante:</b> " . $this->_emergencia->eme_c_nombre_informante . "<br>";
        $mensaje .= "<b>Teléfono del informante:</b> " . $this->_emergencia->eme_c_telefono_informante . "<br><br>";
        $mensaje .= "<br><img src='" . base_url('assets/img/logoseremi.png') . "' alt='Seremi' title='Seremi'/><br>";
        return $mensaje;
    }
    
    /**
     * 
     * @return string
     */
    protected function _listaIdComunasConComa(){
        $retorno = "";
        $coma = "";
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($this->_emergencia->eme_ia_id);
        if(count($lista_comunas)>0){
            foreach($lista_comunas as $comuna){
                $retorno .= $coma . $comuna["com_ia_id"];
                $coma = ",";
            }
        }
        
        return $retorno;
    }
    
    /**
     * 
     * @return string
     */
    protected function _listaNombreComunasConComa(){
        $retorno = "";
        $coma = "";
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($this->_emergencia->eme_ia_id);
        if(count($lista_comunas)>0){
            foreach($lista_comunas as $comuna){
                $retorno .= $coma . $comuna["com_c_nombre"];
                $coma = ",";
            }
        }
        
        return $retorno;
    }
    
    /**
     * 
     * @return string
     */
    protected function _getNombreTipo(){
        $estado = $this->_emergencia_tipo_model->getById($this->_emergencia->tip_ia_id);
        if(!is_null($estado)){
            return $estado->aux_c_nombre;
        } else {
            return "";
        }
    }
    
    
}
