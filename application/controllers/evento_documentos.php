<?php

require_once(__DIR__ . "/mantenedor_documentos.php");

/**
 * 
 */
Class Evento_documentos extends Mantenedor_documentos {
    
    
    public function __construct() {
        parent::__construct();
        $this->load->model("emergencia_model","_emergencia_model");
    }
    
    /**
     * 
     */
    public function index(){
        $params = $this->uri->uri_to_assoc();
        
        $evento = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($evento)){
            $this->session->set_userdata("mantenedor_documentos_eliminar", array());       
            
            $this->layout_assets->addJs("library/DataTables-1.10.8/js/jquery.dataTables.js")
                                ->addJs("library/DataTables-1.10.8/js/dataTables.bootstrap.js")
                                ->addJs("library/bootbox-4.4.0/bootbox.min.js")
                                ->addJs("library/dropzone/dropzone.js")
                                ->addJs("modulo/documentos/base.js")
                                ->addJs("modulo/evento_documentos/documentos.js")
                                ->addJs("modulo/evento_documentos/index.js");    
            
            
            $this->template->parse(
                "default", 
                "pages/evento_documentos/index", 
                array(
                    "id" => $evento->eme_ia_id,
                    "nombre" => $evento->eme_c_nombre_emergencia,
                    "cantidad" => 0)
                );
        } else {
            throw new Exception("El evento no existe");
        }
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_documentos(){
        $params = $this->input->post(null, true);
        $this->load->helper(array("modulo/usuario/usuario"));
        $lista = $this->archivo_model->buscar(array("evento" => $params["id"]));
        $this->load->view("pages/mantenedor_documentos/grilla_documentos", array("lista" => $lista));
    }
}

