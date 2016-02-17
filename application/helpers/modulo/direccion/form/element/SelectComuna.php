<?php

require_once(APPPATH . 'third_party/Cosof/Form/Select.php');

/**
 * Elemento select para comuna
 */
Class Direccion_Form_Element_SelectComuna{
    
    /**
     *
     * @var int 
     */
    protected $_id_region;
    
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
        $this->ci->load->model("comuna_model");
        $this->ci->load->library("session");
 
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
    public function render($default = array()){
        $this->_element->addAtributos(array("multiple" => "true", "class" => "select2-tags", "data-placeholder" => "Seleccione una opción"));
        $this->_element->setNombre($this->_nombre);
        $this->_element->populate($this->_listar());
        $this->_element->setOptionId("com_ia_id");
        $this->_element->setOptionName("com_c_nombre");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista de comunas
     * @return array
     */
    protected function _listar(){
        return $this->ci->comuna_model->listarComunasPorUsuario($this->ci->session->userdata("session_idUsuario"));
    }
}

