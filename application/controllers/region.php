<?php

class Region extends MY_Controller {
    
    /**
     *
     * @var Region_Model 
     */
    public $_region_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("region_model", "_region_model");
    }
    
    /**
     * 
     */
    public function json_region(){
        header('Content-type: application/json');
        $id = $this->input->post('id');
        $region = $this->_region_model->getById($id);
        echo Zend_Json_Encoder::encode(array("id" => $region->reg_ia_id,
                                             "nombre" => $region->reg_c_nombre,
                                             "lat" => $region->lat,
                                             "lon" => $region->lon));
    }
}
