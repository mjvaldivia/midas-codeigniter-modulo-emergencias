<?php

Class Usuario_Form_Element_SelectOficina{
    
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
     * @var Oficina_Model 
     */
    protected $_oficina_model;
    
    /**
     *
     * @var int 
     */
    protected $_id_region = NULL;
    
    /**
     * 
     */
    public function __construct() {
        $this->ci =& get_instance();
        $this->_element = New Cosof_Form_Select();
        $this->ci->load->model("oficina_model");
        $this->_oficina_model = New Oficina_Model();
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
     * @param int $id_region
     */
    public function setRegion($id_region){
        $this->_id_region = $id_region;
    }
    
    /**
     * 
     * @param array $default valores por defecto
     * @return string html
     */
    public function render($default = array()){
        $this->_element->setNombre($this->_nombre);
        $this->_element->populate($this->_listar());
        $this->_element->setOptionId("ofi_ia_id");
        $this->_element->setOptionName("ofi_c_nombre");
        return $this->_element->render($this->_nombre, $default);
    }
    
    /**
     * Lista
     * @return array
     */
    protected function _listar(){
        if(is_null($this->_id_region)){
            return $this->_oficina_model->listar();
        } else {
            return $this->_oficina_model->listarPorRegion($this->_id_region);
        }
    }
}

