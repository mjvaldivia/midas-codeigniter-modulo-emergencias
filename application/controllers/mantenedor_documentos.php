<?php

Class Mantenedor_documentos extends MY_Controller {
    
    /**
     *
     * @var Archivo_Model 
     */
    public $archivo_model;
        
    /**
     *
     * @var MY_Session 
     */
    public $session;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("archivo_model", "archivo_model");
        sessionValidation();
    }
    
    /**
     * 
     */
    public function index(){
        $this->session->set_userdata("mantenedor_documentos_eliminar", array());        
        $this->template->parse("default", "pages/mantenedor_documentos/index", array("cantidad" => 0));
    }

    /**
     * Sube el documentos
     * @return boolean
     * @throws Exception
     */
    public function upload(){
        $this->load->library(array("archivo/archivo_upload")); 
        if($this->archivo_upload->upload("file")){
            return true;
        } else {
            throw new Exception($this->archivo_upload->getError());
        }
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_documentos(){
        $this->load->helper(array("modulo/usuario/usuario"));
        $lista = $this->archivo_model->buscar(array());
        $this->load->view("pages/mantenedor_documentos/grilla_documentos", array("lista" => $lista));
    }
    
    /**
     * Se limpia la sesion
     */
    public function limpiar_seleccion(){
        $this->session->set_userdata("mantenedor_documentos_eliminar", array());
        echo json_encode(array("correcto" => true));
    }
    
    /**
     * Elimina los archivos seleccionados
     */
    public function eliminar_seleccion(){
        $documentos_seleccionados = $this->session->userdata('mantenedor_documentos_eliminar');
        if(count($documentos_seleccionados)>0){
            foreach($documentos_seleccionados as $id_archivo => $void){
                $this->archivo_model->remove($id_archivo);
            }
        }
        $this->session->set_userdata("mantenedor_documentos_eliminar", array());  
        echo json_encode(array("correcto" => true));
    }
    
    /**
     * Selecciona archivo para eliminar
     */
    public function selecciona_archivo(){
        $params = $this->input->post(null, true);
        $documentos_seleccionados = $this->session->userdata('mantenedor_documentos_eliminar');
        
        $archivo = $this->archivo_model->getById($params["id"]);
        if(!is_null($archivo)){
            if($params["seleccionado"] == 1){
                $documentos_seleccionados[$archivo->arch_ia_id] = true;
            } else {
                if(isset($documentos_seleccionados[$archivo->arch_ia_id])){
                    unset($documentos_seleccionados[$archivo->arch_ia_id]);
                }
            }
        }
        $this->session->set_userdata("mantenedor_documentos_eliminar", $documentos_seleccionados);
        
        $respuesta = array();
        $respuesta["cantidad"] = count($documentos_seleccionados);
        
        echo json_encode($respuesta);
    }
}

