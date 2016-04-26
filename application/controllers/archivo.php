<?php
/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Archivo extends MY_Controller {

    public function upload_temporal(){
        $this->load->model("archivo_tipo_model", "_archivo_tipo_model");
        
        header('Content-type: application/json');
        
        $this->load->library(array(
            "visor/upload/visor_upload_temp_kml")
        );
        
        $params = $this->input->post(null, true);
        
        $correcto = true;
        $error    = "";
          
        $retorno_archivo = $this->visor_upload_temp_kml->upload(
            array(
                'png',
                'jpg',
                'jpeg',
                'bmp',
                'pdf',
                'doc',
                'dot',
                'docx',
                'dotx',
                'docm',
                'dotm',
                'xls',
                'xlt',
                'xla',
                'xlsx',
                'xltx',
                'xlsm',
                'xltm',
                'xlam',
                'xlsb',
                'ppt',
                'pot',
                'pps',
                'ppa',
                'pptx',
                'potx',
                'ppsx',
                'ppam',
                'pptm',
                'potm',
                'ppsm',
                'txt')
        ); 
        
        if(!$retorno_archivo["correcto"]){
            $correcto = false;
            $error = $retorno_archivo["mensaje"];  
        }  
        
        $nombre_tipo = "";
        $tipo = $this->_archivo_tipo_model->getById($params["tipo"]);
        if(!is_null($tipo)){
            $nombre_tipo = $tipo->nombre;
        }
        
        $retorno = array("correcto" => $correcto,
                         "descripcion" => $params["descripcion"],
                         "archivo" => $retorno_archivo["archivo_nombre"],
                         "tipo" => $params["tipo"],
                         "nombre_tipo" => $nombre_tipo,
                         "hash" => $retorno_archivo["hash"],
                         "errores" => $error);
        
        echo json_encode($retorno);
    }
    
    /**
     * Muestra KML temporal
     * @throws Exception
     */
    public function download_temporal(){
        $this->load->library(array("cache"));
        $params = $this->uri->uri_to_assoc();
        $cache = Cache::iniciar();
        if($archivo = $cache->load($params["hash"])){
            header("Content-Type: " . $archivo["mime"]);
            header("Content-Disposition: inline;filename=" . $archivo["archivo_nombre"]); 
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public'); 
            echo $archivo["archivo"];
        }
    }
    
    
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
        $this->ArchivoModel->descargar($params['hash']);
    }


    function view_file_mail(){
        $this->load->helper(array("session", "debug"));

        $params = $this->uri->uri_to_assoc();
        $this->load->model("archivo_model", "ArchivoModel");
        $this->ArchivoModel->descargar($params['k']);
    }

}
