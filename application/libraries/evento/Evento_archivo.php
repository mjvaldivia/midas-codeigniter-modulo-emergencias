<?php

Class Evento_archivo{
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    protected $_evento;
    
    /**
     * Constructor
     */
    public function __construct($id_evento) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("emergencia_model", "_emergencia_model");
        
        $this->_evento = $this->_ci->_emergencia_model->getById($id_evento);
        if(is_null($this->_evento)){
            throw new Exception("El evento no existe");
        }
    }
    
    public function addArchivo($hash){
        
    }
}

