<?php

class Mantenedorusuario extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model
     */
    public $usuario_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("usuario_model", "usuario_model");
    }
    
    /**
     * Listado de usuarios
     */
    public function index(){
        $this->load->helper(array("modulo/direccion/region"));
        $this->template->parse("default", "pages/usuario/index", array());
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla(){
        $params = $this->input->post(null, true);
        
        $lista = $this->usuario_model->listarUsuariosEmergencia();
        
        $this->load->view("pages/usuario/grilla/grilla-usuarios", array("lista" => $lista));
    }
}

