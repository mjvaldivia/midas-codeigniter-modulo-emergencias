<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * Controlador para alarmas
 */
class Migracion extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model 
     */
    public $_usuario_model;
    
     /**
     *
     * @var Usuario_Region_Model 
     */
    public $_usuario_region_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();        
        $this->load->model("usuario_model", "_usuario_model");
        $this->load->model("usuario_region_model", "_usuario_region_model");
    }
    
    public function usuarios_region(){
        $lista = $this->_usuario_model->listar();
        foreach($lista as $usuario){
            $region = array($usuario["reg_ia_id"]);
            
            $this->_usuario_region_model->query()
                                        ->insertOneToMany("id_usuario", "id_region", $usuario["usu_ia_id"], $region);
        }
    }
    
}

