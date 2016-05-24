<?php

require_once(__DIR__ . "/mantenedor_documentos.php");

/**
 * 
 */
Class Evento_documentos extends Mantenedor_documentos {
    
    
    public function __construct() {
        parent::__construct();
        
        $this->load->helper(array("modulo/archivo/archivo",
                                  "modulo/alarma/alarma_form"));
  
        $this->load->model("emergencia_model","_emergencia_model");
        $this->load->model("emergencia_archivo_model","_emergencia_archivo_model");
    }
    
    /**
     * 
     */
    public function index(){
        $params = $this->uri->uri_to_assoc();
        
        $evento = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($evento)){
            $this->session->set_userdata("mantenedor_documentos_eliminar", array());       
            
            $this->layout_assets->addCss("js/library/DataTables-1.10.8/css/dataTables.bootstrap.css")
                                ->addJs("library/DataTables-1.10.8/js/jquery.dataTables.js")
                                ->addJs("library/DataTables-1.10.8/js/dataTables.bootstrap.js")
                                ->addJs("library/bootbox-4.4.0/bootbox.min.js")
                                ->addCss("js/library/bootstrap-fileinput/css/fileinput.css")
                                ->addJs("library/bootstrap-fileinput/js/fileinput.js")
                                ->addJs("library/bootstrap-fileinput/js/fileinput_locale_es.js")
                                
                                //->addJs("library/dropzone/dropzone.js")
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
     * Guarda archivos adjuntos
     * @param int $id_evento
     */
    public function guardar_archivo(){
        
        header('Content-type: application/json');
        
        $this->load->library(
            array("evento/evento_archivo")
        );
        
        $params = $this->input->post(null, true);
        $evento = $this->_emergencia_model->getById($params["id"]);
        if(!is_null($evento)){
            $this->evento_archivo->setEvento($evento->eme_ia_id);
            $this->evento_archivo->setEliminar(false);
            $this->evento_archivo->addArchivo(
                $params["archivos_hash"], 
                $params["archivos_descripcion"],
                $params["archivos_tipo"], 
                null,
                $this->session->userdata('session_idUsuario')
            );
            

            $this->evento_archivo->guardar();
        }
        
        $respuesta = array(
            "correcto" => true
        );

        echo Zend_Json::encode($respuesta);

    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_documentos(){
        
        $this->session->set_userdata("mantenedor_documentos_eliminar", array());
        
        $params = $this->input->post(null, true);
        $this->load->helper(array("modulo/usuario/usuario"));
        $lista = $this->_emergencia_archivo_model->listar(
            array(
                "emergencia" => $params["id"],
                "search" => $params["search"]
            )    
        );
        $this->load->view("pages/evento_documentos/grilla_documentos", array("lista" => $lista));
    }
}

