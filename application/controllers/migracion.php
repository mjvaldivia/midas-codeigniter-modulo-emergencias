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
     * @var Usuario2_Model 
     */
    public $_usuario2_model;
    
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
        $this->load->model("usuario2_model", "_usuario2_model");
        $this->load->model("usuario_region_model", "_usuario_region_model");
    }
    
    public function corregirEmails(){
        $lista = $this->_usuario2_model->listar();
        foreach($lista as $usuario){
            
            $validador = New Zend_Validate_EmailAddress();
            if($validador->isValid($usuario["usu_c_email"])) {

                $encontrado = $this->_usuario_model->getByNombre(
                    $usuario["usu_c_nombre"], 
                    $usuario["usu_c_apellido_paterno"], 
                    $usuario["usu_c_apellido_materno"]
                );

                if(!is_null($encontrado)){
                    $data["usu_c_email"] = $usuario["usu_c_email"];
                    $this->_usuario_model->update($data, $encontrado->usu_ia_id);
                    echo $usuario["usu_c_email"] . "<br>";
                }
            }
            
        }
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

