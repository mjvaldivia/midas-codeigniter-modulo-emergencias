<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para comuna
 */
Class Emergencia_Element_SelectTipo{
    
    /**
     *
     * @var Cosof_Form_Select
     */
    protected $_element;
    
    /**
     *
     * @var type 
     */
    protected $ci;
    
    /**
     * Nombre del input
     * @var string 
     */
    protected $_nombre;
    
    /**
     *
     * @var Tipo_Emergencia_Model
     */
    public $tipo_emergiencia_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct($ci) {
        $this->ci = $ci;
        $this->_element = New Cosof_Form_Select();
        
        $this->ci->load->model("tipo_emergencia_model");
        $this->tipo_emergiencia_model = New Tipo_Emergencia_Model();
    }
    
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
        $this->_element->setOptionId("aux_ia_id");
        $this->_element->setOptionName("aux_c_nombre");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista de comunas
     * @return array
     */
    protected function _listar(){
        return $this->tipo_emergiencia_model->get();
    }
}