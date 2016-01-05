<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para comuna
 */
Class Usuario_Form_Element_SelectActivo{
    
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
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
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
     * @param array $atributos
     */
    public function setAtributos($atributos){
        $this->_element->addAtributos($atributos);
    }
    
    /**
     * 
     * @param array $default valores por defecto
     * @return string html
     */
    public function render($default = array()){
        $this->_element->setNombre($this->_nombre);
        $this->_element->populate($this->_listar());
        $this->_element->setOptionId("value");
        $this->_element->setOptionName("option");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista 
     * @return array
     */
    protected function _listar(){
        return array(array("value" => 1,
                           "option" => "Si"),
                     array("value" => 2,
                           "option" => "No"));
    }
}
