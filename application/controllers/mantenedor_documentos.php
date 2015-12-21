<?php

Class Mantenedor_documentos extends MY_Controller {
    
    /**
     *
     * @var Archivo_Model 
     */
    protected $_archivo_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("archivo_model", "archivo_model");
        sessionValidation();
    }
    
    public function index(){
        $this->template->parse("default", "pages/mantenedor_documentos/index", array());
    }

    
    public function upload(){
        $this->load->library(array("archivo/archivo_upload")); 
        if($this->archivo_upload->upload("file")){
            return true;
        } else {
            throw new Exception($this->archivo_upload->getError());
        }
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_documentos(){
        $this->load->helper(array("modulo/usuario/usuario"));
        $lista = $this->archivo_model->buscar(array());
        $this->load->view("pages/mantenedor_documentos/grilla_documentos", array("lista" => $lista));
    }
}

