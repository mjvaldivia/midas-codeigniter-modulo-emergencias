<?php

class Mantenedor_permiso extends MY_Controller {
    
    /**
     *
     * @var Permiso_Model
     */
    public $permiso_model;
    
    /**
     *
     * @var Rol_Model 
     */
    public $rol_model;
    
    /**
     *
     * @var Modulo_Model 
     */
    public $modulo_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper(array("modulo/permiso/permiso"));
        $this->load->model("permiso_model", "permiso_model");
        $this->load->model("rol_model", "rol_model");
        $this->load->model("modulo_model", "modulo_model");
    }
    
    /**
     * Listado de usuarios
     */
    public function index()
    {
        $this->template->parse("default", "pages/mantenedor_permisos/index", array());
    }
    
    /**
     * Carga formulario
     */
    public function form()
    {
        $lista = $this->modulo_model->listarModulosEmergencia();
        $this->load->view("pages/mantenedor_permisos/form", array("lista" => $lista));
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla()
    {
        $params = $this->input->post(null, true);
        $lista = $this->rol_model->listar();
        $this->load->view("pages/mantenedor_permisos/grilla/grilla-permisos", array("lista" => $lista));
    }
}

