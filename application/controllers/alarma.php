<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * Controlador para alarmas
 */
class Alarma extends MY_Controller {

    /**
     *
     * @var Alarma_Model
     */
    public $AlarmaModel;
    
    /**
     *
     * @var Alarma_Comuna_Model
     */
    public $AlarmaComunaModel;
    
    /**
     *
     * @var Alarma_Estado_Model
     */
    public $AlarmaEstadoModel;
    
    /**
     *
     * @var Tipo_Emergencia_Model
     */
    public $emergencia_tipo_model;
    
    /**
     *
     * @var template
     */
    public $template;
    
    /**
     *
     * @var Usuario 
     */
    public $usuario;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("usuario");
        $this->usuario->setModulo("alarma");
        
        $this->load->model("alarma_model", "AlarmaModel");
        $this->load->model("emergencia_comuna_model", "EmergenciaComunaModel");
        $this->load->model("emergencia_estado_model", "EmergenciaEstadoModel");
        $this->load->model("alarma_estado_model", "AlarmaEstadoModel");
        $this->load->model("tipo_emergencia_model", "emergencia_tipo_model");
        sessionValidation();
    }
    
    /**
     * Index
     */
    public function index(){
        $this->load->helper(array("modulo/direccion/comuna",
                                  "modulo/alarma/alarma_form",
                                  "modulo/emergencia/emergencia",
                                  "modulo/emergencia/emergencia_form"));

        if($this->usuario->getPermisoEditar()){
            if(isset($params["tab"])){
                $tab = $params["tab"];
            } else {
                $tab = "nuevo";
            }
        } else {
            $tab = "listado";
        }
        
        $id_estado = Alarma_Estado_Model::REVISION;
        if(isset($params["estado"])){
            switch ($params["estado"]) {
                case "activo":
                    $id_estado = Alarma_Estado_Model::ACTIVADO;
                    break;
                case "rechazado":
                    $id_estado = Alarma_Estado_Model::RECHAZADO;
                    break;
                default:
                    $id_estado = Alarma_Estado_Model::REVISION;
                    break;
            }
        }
      
        $data = array(
            "tab_activo" => $tab,
            "id_estado" => $id_estado,
            "year" => date('Y')
        );
        
        $this->template->parse("default", "pages/alarma/index", $data);
    }
    
    /**
     * Formulario para nueva alarma
     */
    public function form_nueva(){
        $this->load->helper(array("modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"));
        $data = array("form_name" => "form_nueva",
                      "geozone" => "19H");
        $this->load->view("pages/alarma/form", $data);
    }
    
    /**
     * Formulario para editar alarma
     */
    public function form_editar(){
        $this->load->helper(array("modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"));
        $this->load->model('emergencia_model','EmergenciaModel');
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->EmergenciaModel->getById($params["id"]);

        if(!is_null($alarma)){
            $descripcion = preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n","",str_replace("\r","", htmlspecialchars_decode($alarma->eme_c_descripcion))));
            $informacion_adicional = preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n","",str_replace("\r","", htmlspecialchars_decode($alarma->eme_c_informacion_adicional))));
            $data = array("eme_id" => $alarma->eme_ia_id,
                            "nombre_informante"   => $alarma->eme_c_nombre_informante,
                          "nombre_emergencia"   => $alarma->eme_c_nombre_emergencia,
                          "id_tipo_emergencia"  => $alarma->tip_ia_id,
                            "id_estado_emergencia" => $alarma->est_ia_id,
                          "nombre_lugar"        => $alarma->eme_c_lugar_emergencia,
                          "observacion"         => $alarma->eme_c_observacion,
                            "informacion_adicional" => $informacion_adicional,
                            "descripcion" => $descripcion,
                          "fecha_emergencia"    => ISODateTospanish($alarma->eme_d_fecha_emergencia),
                          "latitud_utm"  => $alarma->eme_c_utm_lat,
                          "longitud_utm" => $alarma->eme_c_utm_lng,
                            "nivel_emergencia" => $alarma->eme_nivel);
            if($alarma->est_ia_id == $this->EmergenciaModel->emergencia_activa or $alarma->est_ia_id == $this->EmergenciaModel->emergencia_finalizada){
                $formulario = unserialize($alarma->eme_c_datos_tipo_emergencia);
                foreach($formulario as $key => $value){
                    $data['form_tipo_'.$key] = $value;
                }
            }


            $lista_comunas = $this->EmergenciaComunaModel->listaComunasPorEmergencia($alarma->eme_ia_id);
            
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
            }

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
            
            $data["form_name"] = "form_editar";

            $this->load->view("pages/alarma/form", $data);
        } else {
            show_404();
        }
    }
    
    /**
     * Formulario con datos relacionados a tipo emergencia
     */
    public function form_tipo_emergencia(){
        $this->load->helper(array("modulo/alarma/alarma_form"));
        $this->load->library(array("alarma/alarma_form_tipo")); 
        
        $params = $this->input->post(null, true);
        $this->alarma_form_tipo->setEmergenciaTipo($params["id_tipo"]);
        $this->alarma_form_tipo->setAlarma($params["id"]);
                
        $formulario = $this->alarma_form_tipo->getFormulario();

        if($formulario["form"]){
            $respuesta = array("html" => $this->load->view($formulario["path"], $formulario["data"], true),
                               "form" => $formulario["form"]);
        } else {
            $respuesta = array("form" => false);
        }
        
        echo json_encode($respuesta);
    }
    
    /**
     * Verifica datos generales
     */
    public function ajax_validar_datos_generales(){
        $this->load->library(array("alarma/alarmavalidar"));
        
        $params = $this->input->post(null, true);

        $correcto = $this->alarmavalidar->esValido($params);
        $respuesta = array("correcto" => $correcto,
                           "error"    => $this->alarmavalidar->getErrores());
        
        echo json_encode($respuesta);
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_alarmas(){
        $this->load->helper(array("modulo/emergencia/emergencia",
                                  "modulo/alarma/alarma"));
        $this->load->model('emergencia_model','EmergenciaModel');
        $params = $this->input->post(null, true);
        
        $lista = $this->EmergenciaModel->buscar(array("id_estado" => $params["filtro_id_estado"],
                                                  "id_tipo"   => $params["filtro_id_tipo"],
                                                  "year"      => $params["filtro_year"],
                                                    "nivel" => $params['filtro_nivel']));
        
        $this->load->view("pages/alarma/grilla/grilla-alarmas", array("lista" => $lista));
    }
 
    /**
     * Guarda formulario de alarma
     */
    public function guardaAlarma() {       
        $this->load->library(array("alarma/alarmavalidar", 
                                   "emergencia/emergencia_guardar"));
        
        $params = $this->input->post(null, true);

        $respuesta = array();
        $correcto = $this->alarmavalidar->esValido($params);
        
        if($correcto){

            $usuario = $this->session->userdata('session_idUsuario');
            $this->load->model('alarma_historial_model','AlarmaHistorialModel');

            $this->load->model('emergencia_model','EmergenciaModel');

            $data = array(
                            "eme_c_nombre_informante"   => $params['nombre_informante'],
                            "eme_c_nombre_emergencia"   => $params['nombre_emergencia'],
                            "tip_ia_id"                 => $params['tipo_emergencia'],
                            "est_ia_id"                 => $params['estado_emergencia'],
                            "eme_c_lugar_emergencia" => $params['nombre_lugar'],
                            "eme_d_fecha_emergencia" => spanishDateToISO($params['fecha_emergencia']),
                            "rol_ia_id"              => $this->session->userdata('session_idCargo'),
                            "usu_ia_id"              => $this->session->userdata('session_idUsuario'),
                            "eme_c_descripcion"     => nl2br($params['descripcion_emergencia']),
                            "eme_c_observacion"      => nl2br($params['observacion']),
                            "eme_c_utm_lat" => $params['latitud'],
                            "eme_c_utm_lng" => $params['longitud'],
                            "eme_nivel" => $params['nivel_emergencia']
                           );

            $alerta = $this->EmergenciaModel->query()->getById("eme_ia_id", $params["eme_id"]);

            //la alarma ya existia
            if(!is_null($alerta)){

                $id= $alerta->eme_ia_id;
                $params["eme_id"] = $id;
                $this->EmergenciaModel->query()->update($data, "eme_ia_id", $alerta->eme_ia_id);
                $this->EmergenciaComunaModel->query()->insertOneToMany("eme_ia_id", "com_ia_id", $alerta->eme_ia_id, $params['comunas']);
                $respuesta_email = "";

                /*$historial_comentario = 'La alarma ha sido editada';
                $data = array(
                    'historial_alerta' => $id,
                    'historial_usuario' => $usuario,
                    'historial_fecha' => date('Y-m-d H:i:s'),
                    'historial_comentario' => $historial_comentario
                );
                $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);*/

            //la alarma no existia
            } else {
                $data["eme_d_fecha_recepcion"] = DATE("Y-m-d H:i:s");
                /*$data["est_ia_id"] = Alarma_Model::REVISION;*/
                $id = $this->EmergenciaModel->query()->insert($data);
                $this->EmergenciaComunaModel->query()->insertOneToMany("eme_ia_id", "com_ia_id", $id, $params['comunas']);
                $params["eme_id"] = $id;

                if($params['estado_emergencia'] == $this->EmergenciaModel->en_alerta and !empty($params['correos_evento'])){
                    $respuesta_email = $this->AlarmaModel->enviaCorreo($params);
                }

                if($params['estado_emergencia'] == $this->EmergenciaModel->en_alerta){
                    $estado_emergencia = 'En Alerta';
                }elseif($params['estado_emergencia'] == $this->EmergenciaModel->emergencia_activa){
                    $estado_emergencia = 'Emergencia Activa';
                }elseif($params['estado_emergencia'] == $this->EmergenciaModel->emergencia_finalizada){
                    $estado_emergencia = 'Emergencia Finalizada';
                }
                $historial_comentario = 'Se ha creado el Evento con estado '.$estado_emergencia;
                $data = array(
                    'historial_alerta' => $id,
                    'historial_usuario' => $usuario,
                    'historial_fecha' => date('Y-m-d H:i:s'),
                    'historial_comentario' => $historial_comentario
                );
                $insertHistorial = $this->AlarmaHistorialModel->query()->insert($data);


            }
            $params['form_tipo_acciones'] = nl2br($params['form_tipo_acciones']);

            $this->emergencia_guardar->setEmergencia($params["eme_id"]);
            $this->emergencia_guardar->setTipo($params["tipo_emergencia"]);
            $this->emergencia_guardar->guardarDatosTipoEmergencia($params);

        }
        
        $respuesta["res_mail"] = $respuesta_email;
        $respuesta["correcto"] = $correcto;
        $respuesta["error"]    = $this->alarmavalidar->getErrores();
        
        echo json_encode($respuesta);
    }
    
    /**
     * Elimina la alarma
     */
    public function eliminarAlarma() { 
        $params = $this->uri->uri_to_assoc();

        $res = $this->AlarmaModel->eliminarAlarma($params['id']);
        echo ($res) ? 1 : 0;
    }



    public function obtenerListadoCorreosAlarma(){
        $this->load->model('sendmail_model','SendmailModel');
        $params = $this->input->post(null, true);

        $json['correos'] = $this->SendmailModel->get_destinatariosCorreo($params['tipo_emergencia'],implode(',',$params['comunas_seleccionadas']));

        echo json_encode($json);


    }


    


}
