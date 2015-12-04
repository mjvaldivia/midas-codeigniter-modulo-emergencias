<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Emergencia extends MY_Controller {

     /**
     *
     * @var template
     */
    public $template;
    
    /**
     *
     * @var validar 
     */
    public $validar;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $emergencia_model;
    
    /**
     *
     * @var Alarma_Model 
     */
    public $alarma_model;
    
    /**
     *
     * @var Alarma_Comuna_Model 
     */
    public $alarma_comuna_model;
    
    /**
     *
     * @var Alarma_Estado_Model
     */
    public $alarma_estado_model;
    
    /**
     *
     * @var Emergencia_Estado_Model 
     */
    public $emergencia_estado_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $emergencia_comuna_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("template");
        $this->load->helper(array("session","utils"));

        $this->load->model("emergencia_model", "emergencia_model");
        $this->load->model("emergencia_estado_model", "emergencia_estado_model");
        $this->load->model("emergencia_comuna_model", "emergencia_comuna_model");
        $this->load->model("alarma_model", "alarma_model");
        $this->load->model("alarma_comuna_model", "alarma_comuna_model");
        $this->load->model("alarma_estado_model", "alarma_estado_model");
        
        sessionValidation();
    }
    
    /**
     * Despliega formulario para cerrar emergencia
     */
    public function form_finalizar(){
        $params = $this->uri->uri_to_assoc();
        $emergencia = $this->emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            $data = array("id" => $emergencia->eme_ia_id,
                          "nombre" => $emergencia->eme_c_nombre_emergencia,
                          "fecha" => Date("d-m-Y h:i"));
            
            $this->load->view("pages/emergencia/form-cerrar", $data);
        } else {
            show_404();
        }
    }
    
    /**
     * Finaliza una emergencia
     */
    public function json_finalizar_emergencia(){
        $this->load->library("validar");
        $correcto = true;
        $error = array();
        
        $params = $this->input->post(null, true);
        $emergencia = $this->emergencia_model->getById($params["id"]);
        if(!is_null($emergencia)){
            
            if(!$this->validar->validarFechaSpanish($params["fecha_cierre"])){
                $correcto = false;
                $error["fecha-cierre"] = "Debe ingresar una fecha";
            } else {
                $error["fecha-cierre"] = "";
            }
            
            if(!$this->validar->validarVacio($params["comentarios_cierre"])){
                $correcto = false;
                $error["comentarios_cierre"] = "Debe ingresar los comentarios";
            } else {
                $error["comentarios_cierre"] = "";
            }

            if($correcto){
                $data = array("est_ia_id" => Emergencia_Estado_Model::CERRADA,
                              "eme_d_fecha_cierre" => spanishDateToISO($params["fecha_cierre"]),
                              "eme_c_comentario_cierre" => $params["comentarios_cierre"]);
                $this->emergencia_model->query()->update($data, "eme_ia_id",  $emergencia->eme_ia_id);
            }
            
            $respuesta = array("correcto" => $correcto,
                               "error" => $error);
            
            echo json_encode($respuesta);
        } else {
            show_404();
        }
    }

    
    /**
     * Despliega formulario para ingresar nueva emergencia
     */
    public function form_nueva(){
        $this->load->helper(array("modulo/emergencia/emergencia_form","modulo/direccion/comuna"));
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->alarma_model->getById($params["id"]);
        if(!is_null($alarma)){
            
            $data = array("id" => $alarma->ala_ia_id,
                          "nombre_informante" => $alarma->ala_c_nombre_informante,
                          "telefono_informante" => $alarma->ala_c_telefono_informante,
                          "nombre_emergencia" => $alarma->ala_c_nombre_emergencia,
                          "id_tipo_emergencia" => $alarma->tip_ia_id,
                          "nombre_lugar" => $alarma->ala_c_lugar_emergencia,
                          "observacion" => $alarma->ala_c_observacion,
                          "fecha_emergencia" => ISODateTospanish($alarma->ala_d_fecha_emergencia),
                          "fecha_recepcion" => ISODateTospanish($alarma->ala_d_fecha_recepcion),
                          "geozone" => $alarma->ala_c_geozone,
                          "latitud_utm" => $alarma->ala_c_utm_lat,
                          "longitud_utm" => $alarma->ala_c_utm_lng);
            
            $lista_comunas = $this->alarma_comuna_model->listaComunasPorAlarma($alarma->ala_ia_id);
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
            }
            $data["form_name"] = "form_nueva_emergencia";
            $this->load->view("pages/alarma/form", $data);
        } else {
            show_404();
        }
    }
    
    /**
     * Guarda nueva emergencia
     */
    public function json_activa_alarma(){
        $this->load->library(array("alarma/alarmavalidar", "emergencia/emergenciaemail"));
        //$this->load->library("emergencia/emergenciaemail");
        $correcto = true;
        $error    = array();
        
        $params = $this->input->post(null, true);
        
        $alarma = $this->alarma_model->getById($params["id"]);
        if(!is_null($alarma)){
                        
            $correcto = $this->alarmavalidar->esValido($params);

            $respuesta = array();
            if($correcto){
                
                $data = array(
                              "eme_c_nombre_informante"   => $params["nombre_informante"],
                              "eme_c_telefono_informante" => $params["telefono_informante"],
                              "eme_c_nombre_emergencia"   => $params["nombre_emergencia"],
                              "tip_ia_id"                 => $params["tipo_emergencia"],
                              "eme_d_fecha_emergencia"    => spanishDateToISO($params["fecha_emergencia"]),
                              "eme_c_lugar_emergencia"    => $params["nombre_lugar"],
                              "eme_d_fecha_recepcion"     => spanishDateToISO($params["fecha_recepcion"]),
                              "est_ia_id"         => Emergencia_Estado_Model::EN_CURSO,
                              "ala_ia_id"         => $alarma->ala_ia_id,
                              "eme_c_observacion" => $params["nobservacion"],
                              "rol_ia_id"         => $this->session->userdata('session_idCargo'),
                              "usu_ia_id"         => $this->session->userdata('session_idUsuario')
                             );

                $id = $this->emergencia_model->query()->insert($data);
                $this->emergencia_comuna_model->query()->insertOneToMany("eme_ia_id", "com_ia_id", $id, $params['comunas']);
                
                //se actualiza alarma
                $this->alarma_model->update(array("ala_c_utm_lat" => $params["latitud"], 
                                                  "ala_c_utm_lng" => $params["longitud"],
                                                  "est_ia_id"     => Alarma_Estado_Model::ACTIVADO), 
                                            $params["id"]);
                //envio de email
                $this->emergenciaemail->setEmergencia($id);
                $respuesta["res_mail"] = $this->emergenciaemail->enviar();
            }
            
            $respuesta["correcto"] = $correcto;
            $respuesta["error"]    = $this->alarmavalidar->getErrores();
            
            echo json_encode($respuesta);
        } else {
            show_404();
        }
    }
    
    /**
     * Rechaza la alarma
     */
    public function json_rechaza_alarma() {
        $params = $this->input->post(null, true);
        $alarma = $this->alarma_model->getById($params["id"]);
        if(!is_null($alarma)){
            $this->alarma_model->update(array("est_ia_id" => Alarma_Estado_Model::RECHAZADO), $alarma->ala_ia_id);
            echo json_encode(array("correcto" => true));
        } else {
            show_404();
        }
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

    public function getAlarma() {
        $this->load->helper("utils");
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_model", "EmergenciaModel");

        return $this->EmergenciaModel->getAlarma($params);
    }

    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/emergencia/listado.php")) {
            show_404();
        }
        
        $params = $this->uri->uri_to_assoc();
        $this->load->model("emergencia_estado_model", "Emergencia_Estado_Model");
        $this->load->helper(array("modulo/emergencia/emergencia_form"));
        $id_estado = "";
        if(isset($params["estado"])){
            switch ($params["estado"]) {
                case "en_curso":
                    $id_estado = Emergencia_Estado_Model::EN_CURSO;
                    break;
                case "cerrada":
                    $id_estado = Emergencia_Estado_Model::CERRADA;
                    break;
                default:
                    $id_estado = "";
                    break;
            }
        }

        $data = array(
            "select_estado_id_default" => $id_estado,
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
            show_404();
        }

        $params = $this->uri->uri_to_assoc();
        $data['eme_ia_id'] = $params['id'];

        $this->load->view("pages/emergencia/editarEmergencia", $data);
        
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
        $this->load->library("capa/capageojson");
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
        $tipo_geometria = array();
        
        if(isset($_FILES['input-capa-editar'])){

            $tmp_name = $_FILES['input-capa-editar']['tmp_name'];
            $nombres = $_FILES['input-capa-editar']['name'];
            $size = $_FILES['input-capa-editar']['size'];
            $type = $_FILES['input-capa-editar']['type'];
        }else{
            $tmp_name = $_FILES['input-capa']['tmp_name'];
            $nombres = $_FILES['input-capa']['name'];
            $size = $_FILES['input-capa']['size'];
            $type = $_FILES['input-capa']['type'];

        }
        
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
                        "<input class='propiedades' id='prop_$k' name='prop_$k' type='checkbox' checked=checked  />");
                    $tmp_prop_array[] = $k;
                }
                
                $arr_filename['data'][] = array(
                    $nombres[$i],
                    "<select name=iComunas_".($i+1)." id=iComunas_".($i+1)." class='form-control iComunas required' placeholder='Comuna de la capa' ></select> <input name=tmp_file_".($i+1)." id=tmp_file_".($i+1)." value='$nombre_cache_id' type=hidden />",
                );
                
                $this->capageojson->setGeojson($arr_properties);
                $geometrias = $this->capageojson->listGeometry();
                
                if(in_array("Polygon", $geometrias) OR in_array("MultiPolygon", $geometrias)){
                    $tipo_geometria['data'][] = array("Poligonos",
                                                      "<input name=\"color_".($i+1)."\" id=\"color_".($i+1)."\" placeholder=\"Color del poligono\" type='text' class=\"colorpicker required\" value=\"\"/>");
                }
                
                if(in_array("Point", $geometrias)){
                    $tipo_geometria['data'][] = array("Icono",
                                                      "<select name=\"icono_".($i+1)."\" id=\"icono_".($i+1)."\" style=\"width: 300px\" placeholder=\"Icono de los marcadores\" class=\" select2-images required\">"
                                                    . "<option value=\"\"></option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi.png")."\">Rojo</option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi-yellow.png")."\">Amarillo</option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi-blue.png")."\">Azul</option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi-green.png")."\">Verde</option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi-pink.png")."\">Rosado</option>"
                                                    . "<option value=\"". base_url("assets/img/markers/spotlight-poi-black.png")."\">Negro</option>"
                                                    . "</select>");
                }
                
            }
        }
        echo ($error) ? json_encode(array("uploaded" => 0, 
                                          "error_filenames" => $arr_error_filenames, 
                                          'properties' => $properties, 
                                          'filenames' => $arr_filename,
                                          'geometry' => $tipo_geometria)) 
                      : json_encode(array("uploaded" => 1, 
                                          'properties' => $properties, 
                                          'filenames' => $arr_filename,
                                          'geometry' => $tipo_geometria));
    }
    public function subir_IconTemp() {
        
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        if(isset($_FILES['input-icon-editar'])){
            $tmp_name = $_FILES['input-icon-editar']['tmp_name'];    
        }else{
            $tmp_name = $_FILES['input-icon']['tmp_name'];    
        }
        
        

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
