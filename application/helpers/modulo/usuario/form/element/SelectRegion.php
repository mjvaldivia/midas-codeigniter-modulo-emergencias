<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

Class Usuario_Form_Element_SelectRegion{
    
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
     * @var Region_Model 
     */
    protected $_region_model;
    
    /**
     * 
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
        
        $this->ci->load->model("usuario_region_model", "_usuario_region_model");
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
        $this->_element->setOptionId("reg_ia_id");
        $this->_element->setOptionName("reg_c_nombre");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista
     * @return array
     */
    protected function _listar(){

        return $this->_usuario_region_model->listarRegionPorUsuario(
                $this->ci->session->userdata("session_idUsuario")
        );

    }
}

