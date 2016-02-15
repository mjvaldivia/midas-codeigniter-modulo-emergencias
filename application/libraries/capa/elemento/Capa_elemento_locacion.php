<?php

Class Capa_elemento_locacion{
    
    /**
     *
     * @var array 
     */
    protected $_data;
    
    /**
     *
     * @var CI_Controller 
     */
    protected $_ci;
    
    /**
     *
     * @var int 
     */
    protected $_id_comuna = 0;
    
    /**
     *
     * @var int 
     */
    protected $_id_provincia = 0;
    
    /**
     *
     * @var int 
     */
    protected $_id_region = 0;
    
    /**
     * 
     * @param array $data
     */
    public function __construct($data) {
        $this->_ci =& get_instance();
        $this->_ci->load->model("comuna_model","comuna_model");
        $this->_ci->load->model("provincia_model","provincia_model");
        $this->setData($data);
    }
    
    /**
     * 
     * @param array $data
     */
    public function setData($data){
        $this->_data = $data;
    }
    
    /**
     * 
     * @return int
     */
    public function getComuna(){
        return $this->_id_comuna;
    }
    
    /**
     * 
     * @return int
     */
    public function getProvincia(){
        return $this->_id_provincia;
    }
    
    /**
     * 
     * @return int
     */
    public function getRegion(){
        return $this->_id_region;
    }
    
    /**
     * Procesa y busca la locacion
     */
    public function process(){
        if(isset($this->_data["COMUNA"])){
            $comuna = $this->_ci->comuna_model->getOneByName($this->_data["COMUNA"]);
            if(!is_null($comuna)){
                $this->_id_comuna = $comuna->com_ia_id;
                $this->_id_provincia = $comuna->prov_ia_id;
            }
        }
        
        if(isset($this->_data["PROVINCIA"])){
            $provincia = $this->_ci->provincia_model->getOneByName($this->_data["PROVINCIA"]);
            if(!is_null($provincia)){
                $this->_id_provincia = $provincia->prov_ia_id;
                $this->_id_region = $provincia->reg_ia_id;
            }
        }
        
        if(isset($this->_data["REGION"])){
            $region = $this->_ci->provincia_model->getOneByName($this->_data["REGION"]);
            if(!is_null($region)){
                $this->_id_region = $region->reg_ia_id;
            }
        }
    }
}

