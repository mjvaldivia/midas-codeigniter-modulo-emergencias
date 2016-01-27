<?php

/**
 * @author Vladimir
 * @since 14-09-15
 */
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * 
 */
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

        $this->load->model("emergencia_model", "emergencia_model");
        $this->load->model("emergencia_estado_model", "emergencia_estado_model");
        $this->load->model("emergencia_comuna_model", "emergencia_comuna_model");
        $this->load->model("alarma_model", "alarma_model");
        $this->load->model("alarma_comuna_model", "alarma_comuna_model");
        $this->load->model("alarma_estado_model", "alarma_estado_model");
        
        sessionValidation();
    }

    /**
     * Despliega formulario para ingresar nueva emergencia
     */
    public function form_nueva()
    {
        $params = $this->uri->uri_to_assoc();
        
        $this->load->helper(
                            array(
                                  "modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"
                                 )
                           );
        
        $this->load->library(
                             array(
                                   "emergencia/emergencia_edit"
                                  )
                            );

        $this->emergencia_edit->setAlarma($params["id"]);
        $data = $this->emergencia_edit->getNewData();
        
        $data["form_name"] = "form_nueva_emergencia";
        $this->load->view("pages/alarma/form", $data);
       
    }
    
    /**
     * Despliega formulario para editar la emergencia
     */
    public function form_editar()
    {
        $params = $this->uri->uri_to_assoc();
        
        $this->load->helper(
                            array(
                                  "modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"
                                 )
                           );
        
        $this->load->library(
                             array(
                                   "emergencia/emergencia_edit"
                                  )
                            );
        
        $this->emergencia_edit->setEmergencia($params["id"]);
        $data = $this->emergencia_edit->getEditData();

        /* revisar adjuntos de emergencia */
        $adjuntos = array();
        $dir_adjuntos = 'media/doc/emergencia/'.$params['id'].'/adjuntos/';
        if(is_dir($dir_adjuntos)){
            $readDir = array_diff(scandir($dir_adjuntos), array('..', '.'));
            if(count($readDir) > 0){
                $this->load->model('archivo_model','ArchivoModel');
                foreach($readDir as $file){
                    $data_adjunto = $this->ArchivoModel->getByPath($dir_adjuntos.$file);
                    $data_adjunto[0]['nombre'] = $file;
                    $data_adjunto[0]['path'] = site_url() . '/archivo/download_file/k/'.$data_adjunto[0]['arch_c_hash'];
                    $adjuntos[] = $data_adjunto[0];

                }
                $data['adjuntos'] = $adjuntos;
            }
        }

        $data["form_name"] = "form_editar_emergencia";
        $this->load->view("pages/alarma/form", $data);
    }
    
    /**
     * Guarda la emergencia
     */
    public function save_editar(){
        $this->load->library(array("alarma/alarmavalidar", 
                                   "emergencia/emergencia_guardar"));
        
        $correcto = true;
        
        $params = $this->input->post(null, true);
        
        $emergencia = $this->emergencia_model->getById($params["eme_id"]);
        if(!is_null($emergencia)){
                        
            $correcto = $this->alarmavalidar->esValido($params);

            $respuesta = array();
            if($correcto){
        
                $data = array(
                        //paso 1
                        "eme_c_nombre_informante"   => $params["nombre_informante"],
                        "eme_c_telefono_informante" => $params["telefono_informante"],
                        "eme_c_nombre_emergencia"   => $params["nombre_emergencia"],
                        "tip_ia_id"                 => $params["tipo_emergencia"],
                        "eme_d_fecha_emergencia"    => spanishDateToISO($params["fecha_emergencia"]),
                        "eme_c_lugar_emergencia"    => $params["nombre_lugar"],
                        "eme_c_observacion"         => $params["nobservacion"],
                        //paso 2
                        "eme_c_recursos"            => $params["editar_recursos"],
                        "eme_c_heridos"             => $params["editar_heridos"],
                        "eme_c_fallecidos"          => $params["editar_fallecidos"],
                        "eme_c_riesgo"              => $params["editar_riesgo"],
                        "eme_c_capacidad"           => $params["editar_superada"],
                        "eme_c_descripcion"         => $params["editar_evento"],
                        "eme_c_acciones"            => $params["editar_acciones"],
                        "eme_c_informacion_adicional" => $params["editar_informacion"]
                       );
                
                $this->emergencia_guardar->setEmergencia($emergencia->eme_ia_id);
                $this->emergencia_guardar->guardar($data);
                $this->emergencia_guardar->setComunas($params['comunas']);
                $this->emergencia_guardar->setTipo($params["tipo_emergencia"]);
                $this->emergencia_guardar->guardarDatosTipoEmergencia($params);
                
                //se actualiza alarma
                $this->alarma_model->update(array("ala_c_utm_lat" => $params["latitud"], 
                                                  "ala_c_utm_lng" => $params["longitud"],
                                                  "est_ia_id"     => Alarma_Estado_Model::ACTIVADO), 
                                            $emergencia->ala_ia_id);


                $usuario = $this->session->userdata('session_idUsuario');
                $this->load->model('alarma_historial_model','AlarmaHistorialModel');
                $historial_comentario = 'La emergencia ha sido editada';
                $data = array(
                    'historial_alerta' => $emergencia->ala_ia_id,
                    'historial_usuario' => $usuario,
                    'historial_fecha' => date('Y-m-d H:i:s'),
                    'historial_comentario' => $historial_comentario
                );
                $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);
                
                
                $id = $this->emergencia_guardar->getId();

                /* verificar si existen adjuntos en temporal */
                $directorio = 'media/tmp/';
                $readDir = array_diff(scandir($directorio), array('..', '.'));
                $this->load->model('archivo_model');
                foreach($readDir as $file){
                    if(preg_match("/^".$emergencia->eme_ia_id."-emergencia_adjunto_temp_/",$file)){
                        if(!is_dir('media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/')){
                            mkdir('media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/',0777,true);
                        }
                        $file_nuevo = str_replace('emergencia_adjunto_temp_','',$file);
                        if(rename($directorio.$file, 'media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/'.$file_nuevo)){

                            $ruta = 'media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/'.$file_nuevo;
                            $archivo = $this->archivo_model->file_to_bd('media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/', $file_nuevo, mime_content_type($ruta), $this->archivo_model->TIPO_EMERGENCIA, $emergencia->ala_ia_id, filesize($ruta));
                            $file_nuevo = $archivo . '_'.$file_nuevo;
                            rename($ruta,'media/doc/emergencia/'.$emergencia->eme_ia_id.'/adjuntos/'.$file_nuevo);
                        }

                    }
                }
                
                $respuesta["correcto"] = $correcto;
                $respuesta["error"]    = $this->alarmavalidar->getErrores();
                echo json_encode($respuesta);
            }
        } else {
            show_404();
        }
    }
    
    /**
     * Formulario con datos relacionados a tipo emergencia
     */
    public function form_tipo_emergencia(){
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->library(array("emergencia/emergencia_form_tipo")); 
        
        $params = $this->input->post(null, true);
        
        $this->emergencia_form_tipo->setEmergenciaTipo($params["id_tipo"]);
        $this->emergencia_form_tipo->setEmergencia($params["id"]);
                
        $formulario = $this->emergencia_form_tipo->getFormulario();
        
        if($formulario["form"]){
            $respuesta = array("html" => $this->load->view($formulario["path"], $formulario["data"], true),
                               "form" => $formulario["form"]);
        } else {
            $respuesta = array("form" => false);
        }
        
        echo json_encode($respuesta);
    }
    
    /**
     * Guarda nueva emergencia
     */
    public function save_nuevo(){
        $this->load->library(array("alarma/alarmavalidar", 
                                   "emergencia/emergencia_guardar",
                                   "emergencia/email/emergencia_email_confirmacion"));

        $correcto = true;
        
        $params = $this->input->post(null, true);
        
        $alarma = $this->alarma_model->getById($params["ala_id"]);
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
                              "eme_d_fecha_recepcion"     => DATE("Y-m-d H:i:s"),
                              "est_ia_id"         => Emergencia_Estado_Model::EN_CURSO,
                              "ala_ia_id"         => $alarma->ala_ia_id,
                              "eme_c_observacion" => $params["nobservacion"],
                              "rol_ia_id"         => $this->session->userdata('session_idCargo'),
                              "usu_ia_id"         => $this->session->userdata('session_idUsuario')
                             );
                
                $this->emergencia_guardar->guardar($data);
                $this->emergencia_guardar->setComunas($params['comunas']);
                $this->emergencia_guardar->guardarDatosTipoEmergencia($params);
                
                $id = $this->emergencia_guardar->getId();
                
                //se actualiza alarma
                $this->alarma_model->update(array("ala_c_utm_lat" => $params["latitud"], 
                                                  "ala_c_utm_lng" => $params["longitud"],
                                                  "est_ia_id"     => Alarma_Estado_Model::ACTIVADO), 
                                            $alarma->ala_ia_id);

                $usuario = $this->session->userdata('session_idUsuario');
                $this->load->model('alarma_historial_model','AlarmaHistorialModel');
                $historial_comentario = 'Se ha generado y activado la emergencia';
                $data = array(
                    'historial_alerta' => $alarma->ala_ia_id,
                    'historial_usuario' => $usuario,
                    'historial_fecha' => date('Y-m-d H:i:s'),
                    'historial_comentario' => $historial_comentario
                );
                $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);

                //envio de email
                $this->emergencia_email_confirmacion->setEmergencia($id);
                $respuesta["res_mail"] = $this->emergencia_email_confirmacion->enviar();
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
        $alarma = $this->alarma_model->getById($params["ala_id"]);
        if(!is_null($alarma)){
            $this->alarma_model->update(array("est_ia_id" => Alarma_Estado_Model::RECHAZADO), $alarma->ala_ia_id);

            $usuario = $this->session->userdata('session_idUsuario');
            $this->load->model('alarma_historial_model','AlarmaHistorialModel');
            $historial_comentario = 'Alarma ha sido rechazada';
            $data = array(
                'historial_alerta' => $params["ala_id"],
                'historial_usuario' => $usuario,
                'historial_fecha' => date('Y-m-d H:i:s'),
                'historial_comentario' => $historial_comentario
            );
            $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);
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

        $poligono = null;
        $icono = null;



        for ($i = 0; $i < sizeof($tmp_name); $i++) {
            $nombre_geojson = 'media/tmp/geojson_'.uniqid().'_'.$nombres[$i];
            $tmp_geojson = 'media/tmp/tmp_'.uniqid().'_'.$nombres[$i];
            $geojson = fopen($nombre_geojson, 'w');
            fwrite($geojson,file_get_contents($tmp_name[$i]));
            fclose($geojson);
            error_log('mapshaper -i '.$nombre_geojson.' -simplify 5% -o format=geojson '.$tmp_geojson);
            $mapsharper = shell_exec('mapshaper -i '.$nombre_geojson.' -simplify 5% -o format=geojson '.$tmp_geojson);
            error_log($mapsharper);

            $error = false;
            $fp = file_get_contents($tmp_geojson, 'r');
            
            $arr_properties = json_decode(utf8_encode($fp),true);
            
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
                /*$this->cache->save($nombre_cache_id, $arr_cache, 28800);*/
                $file = fopen('media/tmp/'.$nombre_cache_id,'w+b');
                fwrite($file,serialize($arr_cache));
                fclose($file);

                /* ejecutar script para reducir geojson */

                
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
                
                if(in_array("Polygon", $geometrias) OR in_array("MultiPolygon", $geometrias) or in_array("MultiLineString", $geometrias)){
                    $poligono = array("Poligonos",
                                                      "<input name=\"color_poligono\" id=\"color_poligono\" placeholder=\"Color del poligono o linea\" type='text' class=\"colorpicker required\" value=\"\"/>");
                }
                
                if(in_array("Point", $geometrias)){
                    $icono = array("Icono",
                                                      "<select name=\"icono_color\" id=\"icono_color\" style=\"width: 300px\" placeholder=\"Icono de los marcadores\" class=\" select2-images required\">"
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

            unlink($nombre_geojson);
            unlink($tmp_geojson);
        }

        if(!is_null($poligono))
            $tipo_geometria['data'][] = $poligono;

        if(!is_null($icono))
            $tipo_geometria['data'][] = $icono;


        echo ($error) ? json_encode(array("uploaded" => 0, 
                                          "error_filenames" => $arr_error_filenames, 
                                          'properties' => $properties, 
                                          'filenames' => $arr_filename,
                                          'geometry' => $tipo_geometria)) 
                      : json_encode(array("uploaded" => 1,
                                            'nombre_cache_id' => $nombre_cache_id,
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


    public function subir_AdjuntoEmergenciaTmp(){
        $params = $this->uri->uri_to_assoc();
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        /*if(isset($_FILES['adjunto-emergencia'])){
            $tmp_name = $_FILES['input-icon-editar']['tmp_name'];
        }else{
            $tmp_name = $_FILES['adjunto-emergencia']['tmp_name'];
        }*/

        $tmp_name = $_FILES['adjunto-emergencia']['tmp_name'];
        $name = explode(".",$_FILES['adjunto-emergencia']['name']);
        array_pop($name);
        $name = implode($name);



        $fp = file_get_contents($tmp_name, 'r');


        $nombre_cache_id = $params['id'] . '-emergencia_adjunto_temp_'.$name.'_'.  uniqid();
        $binary_path = ('media/tmp/'.$nombre_cache_id);
        $ftmp = fopen($binary_path, 'w');
        fwrite($ftmp, $fp);





        echo json_encode(array("uploaded" => 1, 'nombre_cache_id' => $nombre_cache_id, 'ruta'=>$binary_path));
    }


    public function borrarAdjuntoEmergencia(){
        $json = array();
        $adjunto = $this->input->post('adjunto');
        $this->load->model('archivo_model','ArchivoModel');
        if($this->ArchivoModel->delete($adjunto)){
            $archivo = $this->ArchivoModel->getByPath($adjunto);
            $this->ArchivoModel->remove($archivo[0]['arch_ia_id']);
            if(is_file($adjunto) === false){
                $json['estado'] = true;
                $json['mensaje'] = 'Adjunto eliminado';
            }

        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al eliminar adjunto. Intente nuevamente';
        }

        echo json_encode($json);
    }


    
}
