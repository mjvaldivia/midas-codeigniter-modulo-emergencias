<?php

Class Alarma_Form_Element_Upload{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    
    protected $_emergencia;
    
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->helper("modulo/archivo/archivo_form");
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        $this->_ci->load->model("emergencia_archivo_model", "_emergencia_archivo_model");
    }
    
    /**
     * 
     * @param int $id_emergencia
     */
    public function setEmergencia($id_emergencia){
        $this->_emergencia = $this->_ci->_emergencia_model->getById($id_emergencia);
    }
    
    /**
     * 
     * @return string
     */
    public function render(){
        return formElementArchivosUpload($this->_getLista());
    }
  
    /**
     * 
     */
    protected function _getLista(){
        $lista = array();
        if(!is_null($this->_emergencia)){
            $lista_archivos = $this->_ci->_emergencia_archivo_model->listaPorEmergencia($this->_emergencia->eme_ia_id);
            if(!is_null($lista_archivos)){
                foreach($lista_archivos as $archivo){
                    $lista[] = $archivo["arch_ia_id"];
                }
            }
        }
        return $lista;
    }
}

