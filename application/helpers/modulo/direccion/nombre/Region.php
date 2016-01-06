<?php

Class Direccion_Nombre_Region{
    
    /**
     *
     * @var Region_Model 
     */
    protected $_region_model;
    
    /**
     *
     * @var array 
     */
    protected $_region = NULL;
    
    /**
     * 
     * @param type $ci
     */
    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model("region_model");
        $this->_region_model = New Region_Model();
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        if(!is_null($this->_region)){
            return $this->_region->reg_c_nombre;
        }
    }
    
    /**
     * 
     * @param int $id
     */
    public function setId($id){
        $this->_region = $this->_region_model->getById($id);
    }
}

