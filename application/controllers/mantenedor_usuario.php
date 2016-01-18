<?php

class Mantenedor_usuario extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model
     */
    public $usuario_model;
    
    /**
     *
     * @var Usuario_Oficina_Model 
     */
    public $usuario_oficina_model;
    
    /**
     *
     * @var Usuario_Rol_Model
     */
    public $usuario_rol_model;
    
    /**
     *
     * @var Usuario_Ambito_Model
     */
    public $usuario_ambito_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper(array("modulo/direccion/region",
                                  "modulo/usuario/usuario"));
        $this->load->model("usuario_model", "usuario_model");
        $this->load->model("usuario_oficina_model", "usuario_oficina_model");
        $this->load->model("usuario_rol_model", "usuario_rol_model");
        $this->load->model("usuario_ambito_model", "usuario_ambito_model");
    }
    
    /**
     * Listado de usuarios
     */
    public function index()
    {
        $this->template->parse("default", "pages/mantenedor_usuarios/index", array());
    }
    
    /**
     * Guardar
     */
    public function save()
    {
        $this->load->library(array("mantenedor/usuario/mantenedor_usuario_validar"));
        
        $params = $this->input->post(null, true);

        $correcto = $this->mantenedor_usuario_validar->esValido($params);
        
        if($correcto){
            $data = array("usu_c_rut" => $params["rut"],
                          "usu_c_nombre" => $params["nombre"],
                          "usu_c_apellido_paterno" => $params["apellido_paterno"],
                          "usu_c_apellido_materno" => $params["apellido_materno"],
                          "sex_ia_id" => $params["sexo"],
                          "usu_c_email" => $params["email"],
                          "usu_c_telefono" => $params["telefono_fijo"],
                          "usu_c_celular" => $params["telefono_celular"],
                          "reg_ia_id" => $params["region"],
                          "crg_ia_id" => $params["cargo"],
                          "est_ia_id" => $params["activo"]
                          );
            
            $usuario = $this->usuario_model->getById($params["id"]);
            if(!is_null($usuario)){
                $this->usuario_model->update($data, $usuario->usu_ia_id);
                $id_usuario = $usuario->usu_ia_id;
            } else {
                $id_usuario = $this->usuario_model->insert($data);
            }
            
            $this->usuario_oficina_model->query()->insertOneToMany("usu_ia_id", "ofi_ia_id", $id_usuario, $params['oficinas']);
            $this->usuario_rol_model->query()->insertOneToMany("usu_ia_id", "rol_ia_id", $id_usuario, $params["roles"]);
            $this->usuario_ambito_model->query()->insertOneToMany("usu_ia_id", "amb_ia_id", $id_usuario, $params["ambitos"]);
        }
        
        $respuesta = array("correcto" => $correcto,
                           "error"    => $this->mantenedor_usuario_validar->getErrores());
        
        echo json_encode($respuesta);
    }
    
    /**
     * Carga formulario
     */
    public function form()
    {
        $this->load->helper(array("modulo/usuario/usuario_form",
                                  "modulo/direccion/region"));
        $this->load->library(array("form/form_select")); 
        
        $data = array();
        
        $params = $this->input->post(null, true);
        $usuario = $this->usuario_model->getById($params["id"]);
        
        if(!is_null($usuario)){
            $data = array("id"  => $usuario->usu_ia_id,
                          "rut" => $usuario->usu_c_rut,
                          "nombre" => $usuario->usu_c_nombre,
                          "apellido_paterno" => $usuario->usu_c_apellido_paterno,
                          "apellido_materno" => $usuario->usu_c_apellido_materno,
                          "sexo" => $usuario->sex_ia_id,
                          "telefono_fijo"    => $usuario->usu_c_telefono,
                          "telefono_celular" => $usuario->usu_c_celular,
                          "email" => $usuario->usu_c_email,
                          "region" => $usuario->reg_ia_id,
                          "cargo" => $usuario->crg_ia_id,
                          "activo" => $usuario->est_ia_id);
            
            $lista_oficinas = $this->usuario_oficina_model->listarOficinasPorUsuario($usuario->usu_ia_id);
            $data["lista_oficinas"] = $this->form_select->populateMultiselect($lista_oficinas, "ofi_ia_id");
            
            $lista_roles    = $this->usuario_rol_model->listarRolesPorUsuario($usuario->usu_ia_id);
            $data["lista_roles"] = $this->form_select->populateMultiselect($lista_roles, "rol_ia_id");
            
            $lista_ambitos  = $this->usuario_ambito_model->listarAmbitosPorUsuario($usuario->usu_ia_id);
            $data["lista_ambitos"] = $this->form_select->populateMultiselect($lista_ambitos, "amb_ia_id"); 
        }
        
        $this->load->view("pages/mantenedor_usuarios/form", $data);
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla()
    {
        $params = $this->input->post(null, true);
        
        $lista = $this->usuario_model->listarUsuariosEmergencia($params["filtro_rut"],$params["filtro_nombre"], $params["filtro_id_region"]);
        
        $this->load->view("pages/mantenedor_usuarios/grilla/grilla-usuarios", array("lista" => $lista));
    }
}

