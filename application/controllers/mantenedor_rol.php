<?php

class Mantenedor_rol extends MY_Controller {
    
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
     *
     * @var Usuario_Model 
     */
    public $usuario_model;
    
    /**
     *
     * @var Usuario_Rol_Model 
     */
    public $usuario_rol_model;
    
    /**
     * Constructor
     */
    public function __construct() 
    {
        parent::__construct();
        $this->load->helper(array("modulo/permiso/permiso"));
        $this->load->model("permiso_model", "permiso_model");
        $this->load->model("usuario_rol_model", "usuario_rol_model");
        $this->load->model("rol_model", "rol_model");
        $this->load->model("modulo_model", "modulo_model");
        $this->load->model("usuario_model", "usuario_model");
    }
    
    public function correccionPermisos(){
        $lista = $this->permiso_model->listar();
        foreach($lista as $permiso){
            $json = array("ver" => 1);
            
            if($permiso["bo_editar"] == 1){
                $json["editar"] = 1;
                $json["ingresar"] = 1;
            }
            
            if($permiso["bo_eliminar"] == 1){
                $json["eliminar"] = 1;
            }
            
            if($permiso["bo_finalizar_emergencia"] == 1){
                $json["finalizar"] = 1;
                $json["conclusiones"] = 1;
            }
            
            if($permiso["bo_reporte_emergencia"] == 1){
                $json["reporte"] = 1;
                $json["exportar"] = 1;
            }
            
            if($permiso["bo_visor_emergencia"] == 1){
                $json["visor"] = 1;
            }
            
            if($permiso["bo_formulario_datos_personales"] == 1){
                $json["datos_personales"] = 1;
            }
            
            if($permiso["bo_visor_emergencia_guardar"] == 1){
                $json["guardar"] = 1;
            }
            
            if($permiso["bo_embarazadas"] == 1){
                $json["embarazadas"] = 1;
            }
            
            $this->permiso_model->update(array("permisos" => Zend_Json::encode($json)), $permiso["rvsp_ia_id"]);
        }
        fb($lista);
    }
    
    /**
     * Listado de usuarios
     */
    public function index()
    {
        $this->template->parse("default", "pages/mantenedor_rol/index", array());
    }
    
    /**
     * 
     */
    public function save()
    {
        $this->load->library(array("mantenedor/rol/mantenedor_rol_validar"));
        
        $params = $this->input->post(null, true);
        
        $correcto = $this->mantenedor_rol_validar->esValido($params);
        
        if($correcto){
            $rol = $this->rol_model->getById($params["id"]);
            $data = array("rol_c_nombre" => $params["nombre"]);
            if(is_null($rol)){
                $this->rol_model->insert($data);
            } else {
                $this->rol_model->update($data, $rol->rol_ia_id);
            }
        }
        
        $respuesta = array("correcto" => $correcto,
                           "error"    => $this->mantenedor_rol_validar->getErrores());
        
        echo json_encode($respuesta);
    }
    
    /**
     * 
     */
    public function eliminar_rol()
    {
        $params = $this->input->post(null, true);
        
        $this->usuario_rol_model->deletePorRol($params["id"]);
        $this->permiso_model->deletePorRol($params["id"]);
        $this->rol_model->delete($params["id"]);
        
        $respuesta = array("correcto" => true,
                           "error"    => array());
        
        echo json_encode($respuesta);
    }
    
    /**
     * Formulario para ingresar/editar rol
     * @throws Exception
     */
    public function form()
    {
        $params = $this->input->post(null, true);
        $rol = $this->rol_model->getById($params["id"]);
        if(!is_null($rol)){
            $data = array("id"  => $rol->rol_ia_id,
                          "nombre" => $rol->rol_c_nombre );
        } else {
            $data = array();
        }
        
        
        $this->load->view("pages/mantenedor_rol/form", $data);
        
    }
    
    /**
     * 
     */
    public function save_permisos()
    {
        $params = $this->input->post(null, true);
        
        //se ingresa el permiso para ver
        $this->permiso_model->query()
                            ->insertOneToMany("rol_ia_id", "per_ia_id", $params["id"], $params["permiso"]["ver"]);

        
        $lista_permisos = $this->permiso_model->listarPorRol($params["id"]);
        if(count($lista_permisos)>0){
            foreach($lista_permisos as $permiso)
            {
                $guardar = array();
                foreach($params["permiso"] as $accion => $modulos){
                    foreach($modulos as $id_modulo){
                        if($id_modulo == $permiso["per_ia_id"]){
                            $guardar[$accion] = 1;
                        }
                    }
                }
                
                $data = array("permisos" => Zend_Json::encode($guardar));
                
                $this->permiso_model->update($data, $permiso["rvsp_ia_id"]);
            }
        }
        
        $respuesta = array("correcto" => true,
                           "error"    => array());
        
        echo json_encode($respuesta);
    }
    
    /**
     * Formulario para editar permisos
     */
    public function form_permisos()
    {
         $this->load->helper(
            array(
                "modulo/permiso/permiso"
            )
        );
        
        $salida = array();
        
        $params = $this->input->post(null, true);
        $lista = $this->modulo_model->listarModulosEmergencia();
        foreach($lista as $permiso){
            
            $permisos_modulo = $this->permiso_model->getByRolAndModulo($params["id"],$permiso["per_ia_id"]);
            if(!is_null($permisos_modulo)){
                $acciones = Zend_Json::decode($permisos_modulo->permisos);
            } else {
                $acciones = array();
            }
            
            $salida[] = array(
                "nombre" => $permiso["per_c_nombre"],
                "id" => $permiso["per_ia_id"],
                "permiso" => $acciones
            );
        }
        
        fb($salida);
        
        $this->load->view(
            "pages/mantenedor_rol/form-permisos", 
            array(
                "lista" => $salida,
                "id_rol" => $params["id"]
            )
        );
    }
    
    
    public function quitar_usuario_rol()
    {
        $params = $this->input->post(null, true);
        $this->usuario_rol_model->deletePorUsuarioYRol($params["id_usuario"], $params["id_rol"]);
        $respuesta = array("correcto" => true,
                           "error"    => array());
        
        echo json_encode($respuesta);
    }
    
    public function usuarios()
    {
        $this->load->helper(array("modulo/direccion/region"));
        $params = $this->input->post(null, true);
        $lista = $this->usuario_model->listarUsuariosPorRol($params["id"]);
        
        $data = array("id" => $params["id"],
                      "lista" => $lista);
        
        $this->load->view("pages/mantenedor_rol/grilla/grilla-usuarios", $data);
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla()
    {
        $params = $this->input->post(null, true);
        $lista = $this->rol_model->listar();
        $this->load->view("pages/mantenedor_rol/grilla/grilla-permisos", array("lista" => $lista));
    }
    
    /**
     * 
     * @param type $per_ia_id
     * @param type $permisos
     * @return int
     */
    protected function _setearPermiso($per_ia_id, $permisos){
        $activo = 0;
        if(is_array($permisos)){
            $seleccionado = array_search($per_ia_id, $permisos);
            if($seleccionado === false){
                $activo = 0;
            } else {
                $activo = 1;
            }
        }
        return $activo;
    }
}

