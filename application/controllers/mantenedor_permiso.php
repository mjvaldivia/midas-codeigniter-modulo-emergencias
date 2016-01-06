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
     * 
     */
    public function save_permisos(){
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
                
                $data = array("bo_editar" => $editar,
                              "bo_eliminar" => $eliminar,
                              "bo_finalizar_emergencia" => $finalizar);
                
                $this->permiso_model->update($data, $permiso["rvsp_ia_id"]);
            }
        }
        
        $respuesta = array("correcto" => true,
                           "error"    => array());
        
        echo json_encode($respuesta);
        
    }
    
    /**
     * 
     */
    public function save(){
        $params = $this->input->post(null, true);
        $rol = $this->rol_model->getById($params["id"]);
        
        $data = array("rol_c_nombre" => $params["nombre"]);
        
        if(is_null($rol)){
            $this->rol_model->insert($data);
        } else {
            $this->rol_model->update($data, $rol->rol_ia_id);
        }
    }
    
    /**
     * Carga formulario
     */
    public function form_permisos()
    {
        $params = $this->input->post(null, true);
        $lista = $this->modulo_model->listarModulosEmergencia();
        $this->load->view("pages/mantenedor_permisos/form", 
                          array("lista" => $lista,
                                "id_rol" => $params["id"]));
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

