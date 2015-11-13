<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Emergencia extends CI_Controller {

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
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("template");
        $this->load->helper(array("session","utils"));

        $this->load->model("emergencia_model", "emergencia_model");
        $this->load->model("emergencia_estado_model", "emergencia_estado_model");
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
                          "fecha_recepcion" => ISODateTospanish($alarma->ala_d_fecha_recepcion));
            
            $lista_comunas = $this->alarma_comuna_model->listaComunasPorAlarma($alarma->ala_ia_id);
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
            }
            
            $this->load->view("pages/emergencia/form-nueva", $data);
        } else {
            show_404();
        }
    }
    
    public function json_guardar_emergencia(){
        $this->load->library("validar");
        
        $correcto = true;
        $error    = array();
        
        $params = $this->input->post(null, true);
        
        $alarma = $this->alarma_model->getById($params["id"]);
        if(!is_null($alarma)){
                        
            if(!$this->validar->validarVacio($params["nueva_nombre_informante"])){
                $correcto = false;
                $error["nueva_nombre_informante"] = "Debe ingresar el nombre del informante";
            } else {
                $error["nueva_nombre_informante"] = "";
            }
            
            if(!$this->validar->validarVacio($params["nueva_nombre_emergencia"])){
                $correcto = false;
                $error["nueva_nombre_emergencia"] = "Debe ingresar el nombre de la emergencia";
            } else {
                $error["nueva_nombre_emergencia"] = "";
            }
            
            if(!$this->validar->validarVacio($params["nueva_nombre_lugar"])){
                $correcto = false;
                $error["nueva_nombre_lugar"] = "Debe ingresar el nombre del lugar";
            } else {
                $error["nueva_nombre_lugar"] = "";
            }
            
            if(!$this->validar->validarVacio($params["nueva_tipo_emergencia"])){
                $correcto = false;
                $error["nueva_tipo_emergencia"] = "Debe ingresar un tipo de emergencia";
            } else {
                $error["nueva_tipo_emergencia"] = "";
            }
            
           
            
            $respuesta = array();
            if($correcto){
                //parche para codigo antiguo
                $respuesta = $this->emergencia_model->guardarEmergencia(array("iNombreInformante" => $params["nueva_nombre_informante"],
                                                                              "iTelefonoInformante" => $params["nueva_telefono_informante"],
                                                                              "iNombreEmergencia" => $params["nueva_nombre_emergencia"],
                                                                              "iTiposEmergencias" => $params["nueva_tipo_emergencia"],
                                                                              "iLugarEmergencia" => $params["nueva_nombre_lugar"],
                                                                              "fechaEmergencia" => $params["nueva_fecha_emergencia"],
                                                                              "fechaRecepcion" => $params["nueva_fecha_recepcion"],
                                                                              "ala_ia_id" => $params["id"],
                                                                              "iObservacion" => $params["nueva_observacion"],
                                                                              "iComunas" => $params["nueva_comunas"]));
            }
            
            $respuesta["correcto"] = $correcto;
            $respuesta["error"]    = $error;
            
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
