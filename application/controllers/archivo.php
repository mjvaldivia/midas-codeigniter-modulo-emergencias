<?php
/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Archivo extends MY_Controller {

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

        echo json_encode(array("uploaded" => true));
    }

    function getDocs() {
        $this->load->helper(array("session", "debug"));

        sessionValidation();
        $params = $this->uri->uri_to_assoc();
        $this->load->model("archivo_model", "ArchivoModel");
        
        echo $this->ArchivoModel->get_docs($params['id'], true, $params['tipo']);
    }

    function download_file() {

        $this->load->helper(array("session", "debug"));

        sessionValidation();
        $params = $this->uri->uri_to_assoc();
        $this->load->model("archivo_model", "ArchivoModel");
        $this->ArchivoModel->descargar($params['k']);
    }


    function view_file_mail(){
        $this->load->helper(array("session", "debug"));

        $params = $this->uri->uri_to_assoc();
        $this->load->model("archivo_model", "ArchivoModel");
        $this->ArchivoModel->descargar($params['k']);
    }

}
