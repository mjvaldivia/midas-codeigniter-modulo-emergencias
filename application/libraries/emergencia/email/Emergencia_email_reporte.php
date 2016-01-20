<?php

Class Emergencia_email_reporte{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var string 
     */
    protected $_to = "";
    
    /**
     *
     * @var string 
     */
    protected $_subject = "";
    
    /**
     *
     * @var string 
     */
    protected $_message = "";
    
    /**
     *
     * @var string 
     */
    protected $_reporte;
    
    /**
     *
     * @var string 
     */
    protected $_dir;
 
    protected $_adjuntos = array();
    
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
        $this->_ci->load->model("sendmail_model");
        $this->_ci->load->model("archivo_model");
        $this->_ci->load->library("string");
        $this->_sendmail_model = $this->_ci->sendmail_model;
    }
    
    /**
     * 
     * @param int $id_archivo
     */
    public function setArchivoAdjunto($id_archivo){
        $archivo = $this->_ci->archivo_model->getById($id_archivo);
        if(!is_null($archivo)){
            $this->_adjuntos[] = $archivo;
        }
    }
    
    /**
     * Agrega el reporte al email
     * @param binary $binary_file
     */
    public function setReporte($binary_file){
        $dir = FCPATH . "media/tmp/" . $this->_ci->string->rand_string(20);
        mkdir($dir);
        $this->_dir = $dir;
        
        
        file_put_contents($dir . "/reporte.pdf", $binary_file);
        
        $this->_reporte = $dir . "/reporte.pdf";
    }
    
    /**
     * 
     * @param string $subject
     */
    public function setSubject($subject){
        $this->_subject = $subject;
    }
    
    /**
     * 
     * @param string $message
     */
    public function setMessage($message){
        $this->_message = $message;
    }
    
    /**
     * 
     * @return boolean
     */
    public function send(){
         if(count($this->_adjuntos) > 0){
            $adjuntos = '<p>Enlaces a adjuntos complementarios</p>';
            foreach($this->_adjuntos as $item){
                $adjuntos .= '<a href="'.site_url('archivo/view_file_mail/k/'.$item->arch_c_hash).'">'.basename(FCPATH . $item->arch_c_nombre).'</a><br/>';
            }
            $this->_message .= $adjuntos;
        }
        
        
        $respuesta = $this->_sendmail_model->emailSend($this->_to, null, null, $this->_subject, $this->_message, false, array($this->_reporte) );
        if(is_file($this->_reporte)){
            unlink($this->_reporte);
            rmdir($this->_dir);
        }
        return $respuesta;
    }
    
    /**
     * 
     * @param string $to
     */
    public function addTo($to){
        if($this->_to == ""){
           $this->_to .= "," . $to;
        } else {
            $this->_to = $to;
        }
    }
}

