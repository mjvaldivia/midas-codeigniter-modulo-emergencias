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
    
    public function save(){
        $params = $this->input->post(null, true);
        
        //se ingresa el permiso para ver
        $this->permiso_model->query()
                            ->insertOneToMany("rol_ia_id", "per_ia_id", $params["id"], $params["ver"]);
        
        $lista_permisos = $this->permiso_model->listarPorRol($params["id"]);
        if(count($lista_permisos)>0){
            foreach($lista_permisos as $permiso){
                
                $editar = 0;
                $eliminar = 0;
                $finalizar = 0;
                
                if(is_array($params["editar"])){
                    $seleccionado = array_search($permiso["per_ia_id"], $params["editar"]);
                    if($seleccionado === false){
                        $editar = 0;
                    } else {
                        $editar = 1;
                    }
                }
                
                if(is_array($params["eliminar"])){
                    $seleccionado = array_search($permiso["per_ia_id"], $params["eliminar"]);
                    if($seleccionado === false){
                        $eliminar = 0;
                    } else {
                        $eliminar = 1;
                    }
                }
                
                if(is_array($params["finalizar"])){
                    $seleccionado = array_search($permiso["per_ia_id"], $params["finalizar"]);
                    if($seleccionado === false){
                        $finalizar = 0;
                    } else {
                        $finalizar = 1;
                    }
                }
                
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
     * Carga formulario
     */
    public function form()
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
}

