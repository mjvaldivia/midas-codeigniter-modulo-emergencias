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
                            ->insertOneToMany("rol_ia_id", "per_ia_id", $params["id"], $params["ver"]);
        
        $lista_permisos = $this->permiso_model->listarPorRol($params["id"]);
        if(count($lista_permisos)>0){
            foreach($lista_permisos as $permiso)
            {
                $editar    = $this->_setearPermiso($permiso["per_ia_id"], $params["editar"]);
                $eliminar  = $this->_setearPermiso($permiso["per_ia_id"], $params["eliminar"]);
                $finalizar = $this->_setearPermiso($permiso["per_ia_id"], $params["finalizar"]);  
                $reporte = $this->_setearPermiso($permiso["per_ia_id"], $params["reporte"]);  
                $visor = $this->_setearPermiso($permiso["per_ia_id"], $params["visor"]);
                $activar_alarma = $this->_setearPermiso($permiso["per_ia_id"], $params["activar_alarma"]);
                
                $data = array("bo_editar" => $editar,
                              "bo_eliminar" => $eliminar,
                              "bo_finalizar_emergencia" => $finalizar,
                              "bo_reporte_emergencia" => $reporte,
                              "bo_visor_emergencia" => $visor,
                              "bo_activar_alarma" => $activar_alarma);
                
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
        $params = $this->input->post(null, true);
        $lista = $this->modulo_model->listarModulosEmergencia();
        $this->load->view("pages/mantenedor_rol/form-permisos", 
                          array("lista" => $lista,
                                "id_rol" => $params["id"]));
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

