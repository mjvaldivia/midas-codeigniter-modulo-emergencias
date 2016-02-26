<?php

Class Formulario_Nombre_Estado{
    
    /**
     *
     * @var CI_Controller
     */
    protected $_ci;
    
    /**
     *
     * @var array 
     */
    protected $_estado = null;
    
    /**
     *
     * @var Rapanui_Dengue_Estado_Model
     */
    public $_rapanui_dengue_estado_model;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("rapanui_dengue_estado_model","_rapanui_dengue_estado_model");
        $this->_rapanui_dengue_estado_model = $this->_ci->_rapanui_dengue_estado_model;
    }
    
    /**
     * 
     * @param int $id_tipo_emergencia
     */
    public function setId($id_estado){
        $this->_estado = $this->_rapanui_dengue_estado_model->getById($id_estado);
    }
    
    /**
     * 
     * @return string
     */
    public function getString(){
        if(!is_null($this->_estado)){
            return $this->_estado->nombre;
        } else {
            return "Caso sospechoso";
        }
    }
}

