<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Emergencia extends CI_Controller {

    public function generaEmergencia() {
        $params = $this->uri->uri_to_assoc();
        if (!file_exists(APPPATH . "/views/pages/emergencia/generaEmergencia.php")) {
            show_404();
        }

        $this->load->library("template");
        $this->load->helper("session");

        if (isset($params['k']) && !$this->session->userdata('session_idUsuario')) {
            $this->load->model("usuario_model", "UsuarioModel");
            $val = $this->UsuarioModel->validaKey($params['k']);
            if ($val['activo'] == 1) {
                $this->UsuarioModel->nologin($val['usu_c_rut']);
            } else {
                sessionValidation();
            }
        } else if (!isset($params['k'])) {

            sessionValidation();
        }
        $data['ala_ia_id'] = $params['id'];
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $this->load->model("emergencia_model", "EmergenciaModel");
        $estado_alerta = $this->EmergenciaModel->revisaEstado($params);

        switch ($estado_alerta) {
            case $this->EmergenciaModel->activado:
                $this->template->parse("default", "pages/emergencia/activada", $data);
                break;
            case $this->EmergenciaModel->rechazado:
                $this->template->parse("default", "pages/emergencia/anulada", $data);
                break;
            default :$this->template->parse("default", "pages/emergencia/generaEmergencia", $data);
                break;
        }
    }

    public function rechaza() {
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $this->load->library(array("template"));
        $this->load->model("emergencia_model", "EmergenciaModel");
        if ($res_guardar = $this->EmergenciaModel->rechazaEmergencia($params)) {
            
        }
        echo ($res_guardar) ? 1 : 0;
    }

    public function jsonTiposEmergencias() {
        $this->load->model("tipo_emergencia_model", "TipoEmergencia");
        $tiposEmergencia = $this->TipoEmergencia->get();

        $json = array();
        foreach ($tiposEmergencia as $te) {
            $json[] = array(
                $te["aux_ia_id"],
                $te["aux_c_nombre"],
            );
        }

        echo json_encode($json);
    }

    public function ingreso() {
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $data = array();
        $data["lastPage"] = "alarma/ingreso";
        $this->load->library(array("template"));
        $this->load->model("emergencia_model", "EmergenciaModel");
        echo $this->EmergenciaModel->guardarEmergencia($params);
    }

    public function getAlarma() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        return $this->EmergenciaModel->getAlarma($params);
    }

    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/emergencia/listado.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        
        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();


        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $data = array(
            "anioActual" => date('Y')
        );

        $this->template->parse("default", "pages/emergencia/listado", $data);
    }

    public function jsonEmergenciasDT() {
        $this->load->model("emergencia_model", "Emergencia");
        $params = $this->uri->uri_to_assoc();
      
        $emergencias = $this->Emergencia->filtrarEmergencias($params);
        
        //var_dump($emergencias);die;
        $json["data"] = $emergencias;
        $json["columns"] = array(
            array("sTitle" => "Emergencias"),
        );
   
        echo json_encode($json);
    }

    public function editar() {
        if (!file_exists(APPPATH . "/views/pages/emergencia/editarEmergencia.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();

        $params = $this->uri->uri_to_assoc();
        date_default_timezone_set("America/Argentina/Buenos_Aires");
        $data['eme_ia_id'] = $params['id'];

        $this->template->parse("default", "pages/emergencia/editarEmergencia", $data);
    }

    public function getEmergencia() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        return $this->EmergenciaModel->getJsonEmergencia($params);
    }

    public function editarEmergencia() { //edicion de una emergencia
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->input->post(null, true);
        $this->load->model("emergencia_model", "EmergenciaModel");

        $res = $this->EmergenciaModel->editarEmergencia($params);

        echo ($res) ? 1 : 0;
    }

    public function subir_CapaTemp() {
        
        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $properties = array();
        $arr_filename = array();
        $tmp_prop_array = array();
        $tmp_name = $_FILES['input-capa']['tmp_name'];
        $nombres = $_FILES['input-capa']['name'];
        $size = $_FILES['input-capa']['size'];
        $type = $_FILES['input-capa']['type'];
        $arr_error_filenames = array();


        for ($i = 0; $i < sizeof($tmp_name); $i++) {

            $error = false;
            $fp = file_get_contents($tmp_name[$i], 'r');
            
            $arr_properties = json_decode($fp,true);
           // var_dump($arr_properties['features'][0]['properties']);die;
           
            if (!isset($arr_properties['features'][0]['properties'])) {
                $error = true;
                $arr_error_filenames[] = $nombres[$i];
            } else {
                $nombre_cache_id = 'file_temp_'.  uniqid();
                $arr_cache= array(
                    'filename' => $nombres[$i],
                    'nombre_cache_id' => $nombre_cache_id,
                    'content' => $fp,
                    'size'=> $size[$i],
                    'type'=> $type[$i]
                    
                );
                $this->cache->save($nombre_cache_id, $arr_cache, 28800);
                
                foreach ($arr_properties['features'][0]['properties'] as $k => $v) {

                    if (in_array($k, $tmp_prop_array)) { // reviso que no se me repitan las propiedades
                        continue;
                    }
                    $properties['data'][] = array($k,
                        "<input id='prop_$k' name='prop_$k' type='checkbox' checked=checked />");
                    $tmp_prop_array[] = $k;
                }
                $arr_filename['data'][] = array(
                    $nombres[$i],
                    "<select name=iComunas_".($i+1)." id=iComunas_".($i+1)." class='form-control iComunas required' placeholder='Comuna de la capa' ></select> <input name=tmp_file_".($i+1)." id=tmp_file_".($i+1)." value='$nombre_cache_id' type=hidden />",
                );
                
            }
        }
        echo ($error) ? json_encode(array("uploaded" => 0, "error_filenames" => $arr_error_filenames, 'properties' => $properties, 'filenames' => $arr_filename)) : json_encode(array("uploaded" => 1, 'properties' => $properties, 'filenames' => $arr_filename));
    }
    public function subir_IconTemp() {
        
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }
        $tmp_name = $_FILES['input-icon']['tmp_name'];
        

        $fp = file_get_contents($tmp_name, 'r');
        

                $nombre_cache_id = 'icon_temp_'.  uniqid();
                $binary_path = ('media/tmp/'.$nombre_cache_id);
                $ftmp = fopen($binary_path, 'w');
                fwrite($ftmp, $fp);


                


        echo json_encode(array("uploaded" => 1, 'nombre_cache_id' => $nombre_cache_id, 'ruta'=>$binary_path));
    }

    public function eliminarEmergencia() { 
        $this->load->helper(array("session", "debug"));
        sessionValidation();
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");
        $res = $this->EmergenciaModel->eliminar_Emergencia($params['id']);
        echo ($res) ? 1 : 0;
    }
    
}
