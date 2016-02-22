<?php

/**
 * Nombre del tipo de archivo
 */
Class Archivo_Nombre_Tipo{
    
    /**
     *
     * @var CI_Controller
     */
    protected $ci;
    
    /**
     *
     * @var object 
     */
    protected $_tipo_archivo;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model("archivo_tipo_model");
    }
    
    /**
     * 
     * @param int $id_tipo_emergencia
     */
    public function setId($id_tipo_archivo){
        $this->_tipo_archivo = $this->ci->archivo_tipo_model->getById($id_tipo_archivo);
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        if(!is_null($this->_tipo_archivo)){
            return $this->_tipo_archivo->nombre;
        }
    }
}

