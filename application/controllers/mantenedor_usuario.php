<?php

class Mantenedor_usuario extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model
     */
    public $usuario_model;
    
    /**
     *
     * @var Oficina_Model 
     */
    public $usuario_oficina_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array("modulo/direccion/region"));
        $this->load->model("usuario_model", "usuario_model");
        $this->load->model("usuario_oficina_model", "usuario_oficina_model");
    }
    
    /**
     * Listado de usuarios
     */
    public function index(){
        $this->template->parse("default", "pages/mantenedor_usuarios/index", array());
    }
    
    /**
     * Carga formulario
     */
    public function form(){
        $this->load->helper(array("modulo/usuario/usuario_form",
                                  "modulo/direccion/region"));
        $this->load->library(array("form/form_select")); 
        
        $data = array();
        
        $params = $this->input->post(null, true);
        $usuario = $this->usuario_model->getById($params["id"]);
        if(!is_null($usuario)){
            $data = array("rut" => $usuario->usu_c_rut,
                          "nombre" => $usuario->usu_c_nombre,
                          "apellido_paterno" => $usuario->usu_c_apellido_paterno,
                          "apellido_materno" => $usuario->usu_c_apellido_materno,
                          "telefono_fijo"    => $usuario->usu_c_telefono,
                          "telefono_celular" => $usuario->usu_c_celular,
                          "email" => $usuario->usu_c_email,
                          "region" => $usuario->reg_ia_id,
                          "cargo" => $usuario->crg_ia_id);
            

            $data["lista_oficinas"] = $this->form_select->populateMultiselect(
                                                    $this->usuario_oficina_model->listarOficinasPorUsuario($usuario->usu_ia_id),
                                                    "ofi_ia_id"
                                                    );
            
            fb($data);
            
        }
        
        $this->load->view("pages/mantenedor_usuarios/form", $data);
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla(){
        $params = $this->input->post(null, true);
        
        $lista = $this->usuario_model->listarUsuariosEmergencia($params["filtro_nombre"], $params["filtro_id_region"]);
        
        $this->load->view("pages/mantenedor_usuarios/grilla/grilla-usuarios", array("lista" => $lista));
    }
}

