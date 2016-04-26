<?php

class Comuna extends MY_Controller {
    
    /**
     *
     * @var Comuna_Model 
     */
    public $comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("comuna_model", "comuna_model");
    }
    
    public function json_comunas_region(){
        header('Content-type: application/json');
        $id = $this->input->post('id');
        $lista_comunas = $this->comuna_model->getComunasPorRegion($id);
        
        $salida = array();
        
        foreach($lista_comunas as $comuna){
            $salida[] = array(
                "com_ia_id" => $comuna->com_ia_id,
                "com_c_nombre" => $comuna->com_c_nombre);
        }
        
        echo Zend_Json_Encoder::encode(
                array(
                    "correcto" => true,
                    "comunas" => $salida)
        );
    }
    
    /**
     * 
     */
    public function json_comunas_usuario(){
        header('Content-type: application/json');
        $lista_comunas = $this->comuna_model->listarComunasPorUsuario($this->_session->userdata("session_idUsuario"));
        echo Zend_Json_Encoder::encode($lista_comunas);
    }
}

