<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Archivo extends CI_Controller {

    public function subir() {
        // load basicos
        $this->load->helper(array("session", "debug"));
        
        sessionValidation();
        $params = $this->uri->uri_to_assoc();
        $tipo_archivo = $params['tipo'];
        $id = $params['id'];
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }
        
        $this->load->model("archivo_model", "ArchivoModel");
        

        foreach ($_FILES as $llave => $valor) {

            $this->ArchivoModel->upload_to_site($valor['name'][0], $valor['type'][0], $valor['tmp_name'][0], $id, $tipo_archivo, $valor['size'][0]);
            
        }

        echo json_encode(array("uploaded" => false));

    }

}
