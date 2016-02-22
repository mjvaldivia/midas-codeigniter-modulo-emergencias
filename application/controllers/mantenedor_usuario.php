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
     *
     * @var Usuario_Region_Model
     */
    public $usuario_region_model;
    
    /**
     *
     * @var Region_Model
     */
    public $region_model;
    
    /**
     *
     * @var Oficina_Model
     */
    public $oficina_model;
    
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
        $this->load->model("usuario_region_model", "usuario_region_model");
        $this->load->model("usuario_rol_model", "usuario_rol_model");
        $this->load->model("usuario_ambito_model", "usuario_ambito_model");
        $this->load->model("region_model", "region_model");
        $this->load->model("oficina_model", "oficina_model");
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
        $this->load->library(array("mantenedor/usuario/mantenedor_usuario_validar",
                                   "form/form_select"));
        
        $params = $this->input->post(null, true);

        $correcto = $this->mantenedor_usuario_validar->esValido($params);
        
        if($correcto){
            $data = array("usu_c_rut" => $params["rut"],
                          "usu_c_nombre" => $params["nombre"],
                          "usu_c_apellido_paterno" => $params["apellido_paterno"],
                          "usu_c_apellido_materno" => $params["apellido_materno"],
                          "sex_ia_id" => $params["sexo"],
                          "bo_nacional" => $params["nacional"],
                          "usu_c_email" => $params["email"],
                          "usu_c_telefono" => $params["telefono_fijo"],
                          "usu_c_celular" => $params["telefono_celular"],
                          "crg_ia_id" => $params["cargo"],
                          "est_ia_id" => $params["activo"]
                          );
            
            $usuario = $this->usuario_model->getById($params["id"]);
            if(!is_null($usuario)){
                $this->usuario_model->update($data, $usuario->usu_ia_id);
                $id_usuario = $usuario->usu_ia_id;
            } else {
                
                $data["usu_c_login"] = $this->_getLogin(str_replace(" ", ".", strtolower(substr($params["nombre"], 0, 1) . "." .$params["apellido_paterno"])));
                
                $rut = explode("-", $params["rut"]);
                $data["usu_c_clave"] = sha1(substr($rut[0], strlen($rut[0])-4, 4));

                $id_usuario = $this->usuario_model->insert($data);
            }
            
            if($params["nacional"] == 1){
                
                $lista_regiones = $this->form_select->populateMultiselect($this->region_model->listar(), "reg_ia_id");
                $this->usuario_region_model->query()
                                           ->insertOneToMany("id_usuario", "id_region", $id_usuario, $lista_regiones);
                
                $lista_oficinas = $this->form_select->populateMultiselect($this->oficina_model->listar(), "ofi_ia_id");
                $this->usuario_oficina_model->query()
                                            ->insertOneToMany("usu_ia_id", "ofi_ia_id", $id_usuario, $lista_oficinas);
                
            } else {
                $this->usuario_region_model->query()
                                           ->insertOneToMany("id_usuario", "id_region", $id_usuario, $params["region"]);

                $this->usuario_oficina_model->query()
                                            ->insertOneToMany("usu_ia_id", "ofi_ia_id", $id_usuario, $params['oficinas']);
            }
            
            
            $this->usuario_rol_model->query()
                                    ->insertOneToMany("usu_ia_id", "rol_ia_id", $id_usuario, $params["roles"]);
            
            $this->usuario_ambito_model->query()
                                       ->insertOneToMany("usu_ia_id", "amb_ia_id", $id_usuario, $params["ambitos"]);
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
        
        $data = array("nacional" => 0);
        
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
                          "cargo" => $usuario->crg_ia_id,
                          "activo" => $usuario->est_ia_id,
                          "nacional" => $usuario->bo_nacional);
            
            $lista_regiones = $this->usuario_region_model->listarPorUsuario($usuario->usu_ia_id);
            $data["lista_regiones"] = $this->form_select->populateMultiselect($lista_regiones, "id_region");
            
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
    
    /**
     * Retorna login
     * @param string $login
     * @param int $intento
     * @return string
     */
    protected function _getLogin($login, $intento = 0){

        if($intento != 0){
            $login .= "." . $intento;
        }
        
        $existe = $this->usuario_model->getByLogin($login);
        if(!is_null($existe)){
            $login = $this->_getLogin($nombre, $apellido, $intento + 1);
        }
        
        return $login;
    }
}

