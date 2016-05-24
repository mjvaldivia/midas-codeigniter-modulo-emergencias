<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para tipo de archivo
 */
Class Archivo_Form_Element_Tipo{
    
    /**
     *
     * @var Cosof_Form_Select
     */
    protected $_element;
    
    /**
     *
     * @var CI_Controller
     */
    protected $ci;
    
    /**
     * Nombre del input
     * @var string 
     */
    protected $_nombre;
    
    /**
     *
     * @var Archivo_Tipo_Model
     */
    public $archivo_tipo_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
        
        $this->ci->load->model("archivo_tipo_model");
        $this->archivo_tipo_model = $this->ci->archivo_tipo_model;
    }
    
    /**
     * 
     * @return Cosof_Form_Select
     */
    public function getElement(){
        return $this->_element;
    }
    
    /**
     * 
     * @param string $nombre
     */
    public function setNombre($nombre){
        $this->_nombre = $nombre;
    }
    
    /**
     * 
     * @param array $default valores por defecto
     * @return string html
     */
    public function render($default = ""){
        $this->_element->setNombre($this->_nombre);
        $this->_element->populate($this->_listar());
        $this->_element->setOptionId("id");
        $this->_element->setOptionName("nombre");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista de comunas
     * @return array
     */
    protected function _listar(){
        return $this->archivo_tipo_model->listar();
    }
}

