<?php

Class Direccion_Nombre_Region{
        
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
        $this->_ci->load->model("region_model","_region_model");
    }
    
    /**
     * 
     * @return string
     */
    public function __toString() {
        if(!is_null($this->_region)){
            return $this->_region->reg_c_nombre;
        } else {
            return "";
        }
    }
    
    /**
     * 
     * @param int $id
     */
    public function setId($id){
        if(Zend_Registry::isRegistered("region_id_" . $id)){
            $this->_region = Zend_Registry::get("region_id_" . $id);
        } else {
            $this->_region = $this->_ci->_region_model->getById($id);
            Zend_Registry::set("region_id_" . $id, $this->_region);
        }
        
        return $this->_region;
    }
}

