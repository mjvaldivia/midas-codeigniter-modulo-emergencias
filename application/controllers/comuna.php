<?php

class Comuna extends MY_Controller {
    
    /**
     *
     * @var Comuna_Model 
     */
    protected $comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("comuna_model", "comuna_model");
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

