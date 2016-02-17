<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * Controlador para alarmas
 */
class Evento extends MY_Controller {
    
    
    /**
     *
     * @var Usuario 
     */
    public $usuario;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $emergencia_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        
        $this->load->library(
            array(
                "usuario", 
                "evento/evento_historial"
            )
        );
        
        $this->usuario->setModulo("alarma");
        
        $this->load->model('emergencia_model','emergencia_model');
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
        
        $this->template->parse("default", "pages/evento/index", $data);
    }
    
    /**
     * 
     */
    public function expediente(){
        sessionValidation();
        $params = $this->uri->uri_to_assoc();

        $this->load->model('alarma_historial_model','AlarmaHistorial');
        $this->load->model('alarma_model','AlarmaModel');
        $this->load->model('emergencia_model','EmergenciaModel');
        $this->load->model('tipo_emergencia_model','TipoEmergenciaModel');
        $this->load->model('alarma_comuna_model','AlarmaComunaModel');
        $this->load->model('emergencia_comuna_model','EmergenciaComunaModel');
        $this->load->model('comuna_model','ComunaModel');
        $this->load->model('alarma_estado_model','AlarmaEstadoModel');
        $this->load->model('archivo_alarma_model','ArchivoAlarmaModel');
        $this->load->model('usuario_model','UsuarioModel');


        $emergencia = $this->EmergenciaModel->getById($params['id']);

        $tipo_emergencia = $this->TipoEmergenciaModel->getById($emergencia->tip_ia_id);
        $estado_alarma = $this->AlarmaEstadoModel->getById($emergencia->est_ia_id);
        $comunas_alarma = $this->EmergenciaComunaModel->listaComunasPorEmergencia($emergencia->eme_ia_id);

        /*$comunas_emergencia = $this->EmergenciaComunaModel->listaComunasPorEmergencia($emergencia->eme_ia_id);*/

        $arr_comunas = array();
        $arr_comunas_emergencia = array();
        foreach($comunas_alarma as $comuna){
            $com = $this->ComunaModel->getById($comuna['com_ia_id']);
            $arr_comunas[] = $com->com_c_nombre;
        }


        $datos_alarma = unserialize($emergencia->ala_c_datos_tipo_emergencia);
        $datos_emergencia = array();
        if($emergencia)
            $datos_emergencia = unserialize($emergencia->eme_c_datos_tipo_emergencia);
        $historial = $this->AlarmaHistorial->getByAlarma($params['id']);

        $arr_documentos = array();
        $documentos = $this->ArchivoAlarmaModel->listaPorAlarma($params['id']);
        if($documentos){
            foreach($documentos as $doc){
                $nombre = explode('/',$doc['arch_c_nombre']);
                $usuario = $this->UsuarioModel->getById($doc['usu_ia_id']);
                $arr_documentos[] = array(
                    'nombre' => $nombre[count($nombre) - 1],
                    'hash' => $doc['arch_c_hash'],
                    'id' => $doc['arch_ia_id'],
                    'usuario' => $usuario->usu_c_nombre.' '.$usuario->usu_c_apellido_paterno.' '.$usuario->usu_c_apellido_materno,
                    'fecha' => $doc['arch_f_fecha']
                );
            }
        }
        $data = array(
            'historial' => $historial,
            'tipo_emergencia' => $tipo_emergencia,
            'estado_alarma' => $estado_alarma,
            'comunas' => implode(', ',$arr_comunas),
            'datos_alarma' => $datos_alarma,
            'emergencia' => $emergencia,
            'datos_emergencia' => $datos_emergencia,
            'documentos' => $arr_documentos
        );

        $this->load->view('pages/evento/expediente',$data);

    }
    
    /**
     * Guarda formulario de alarma
     */
    public function guardar() { 
        header('Content-type: application/json');
        $this->load->library(array("alarma/alarmavalidar", 
                                   "emergencia/emergencia_guardar"));
        
        $params = $this->input->post(null, true);

        $respuesta = array();
        $correcto = $this->alarmavalidar->esValido($params);
        
        if($correcto){

            $data = array(
                "eme_c_nombre_informante" => $params['nombre_informante'],
                "eme_c_nombre_emergencia" => $params['nombre_emergencia'],
                "tip_ia_id"               => $params['tipo_emergencia'],
                "est_ia_id"               => $params['estado_emergencia'],
                "eme_c_lugar_emergencia"  => $params['nombre_lugar'],
                "eme_d_fecha_emergencia"  => spanishDateToISO($params['fecha_emergencia']),
                "rol_ia_id"               => $this->session->userdata('session_idCargo'),
                "usu_ia_id"               => $this->session->userdata('session_idUsuario'),
                "eme_c_descripcion"       => $params['descripcion_emergencia'],
                "eme_c_observacion"       => $params['observacion'],
                "eme_c_utm_lat" => $params['latitud'],
                "eme_c_utm_lng" => $params['longitud'],
                "eme_nivel" => $params['nivel_emergencia']
            );

            $evento = $this->emergencia_model
                           ->query()
                           ->getById("eme_ia_id", $params["eme_id"]);

            //la alarma ya existia
            if(!is_null($evento)){
                $id = $evento->eme_ia_id;
                
                $this->emergencia_model
                     ->update(
                        $data, 
                        $evento->eme_ia_id
                      );
                
                $this->EmergenciaComunaModel->query()->insertOneToMany("eme_ia_id", "com_ia_id", $alerta->eme_ia_id, $params['comunas']);
                $respuesta_email = "";
            } else {
                $data["eme_d_fecha_recepcion"] = DATE("Y-m-d H:i:s");
                
                $id = $this->emergencia_model
                           ->insert($data);
                
                $this->EmergenciaComunaModel->query()->insertOneToMany("eme_ia_id", "com_ia_id", $id, $params['comunas']);
                
                $params["eme_id"] = $id;

                if($params['estado_emergencia'] == Emergencia_Estado_Model::EN_ALERTA and !empty($params['correos_evento'])){
                    $respuesta_email = $this->AlarmaModel->enviaCorreo($params);
                }

                if($params['estado_emergencia'] == Emergencia_Estado_Model::EN_ALERTA){
                    $estado_emergencia = 'En Alerta';
                }elseif($params['estado_emergencia'] == Emergencia_Estado_Model::EN_CURSO){
                    $estado_emergencia = 'Emergencia Activa';
                }elseif($params['estado_emergencia'] == Emergencia_Estado_Model::FINALIZADA){
                    $estado_emergencia = 'Emergencia Finalizada';
                }
                
                Evento_historial::putHistorial(
                    $id, 
                    'Se ha creado el Evento con estado ' . $estado_emergencia
                );


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
     * Elimina emergencia
     */
    public function eliminar() { 
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $res = $this->emergencia_model->delete($params['id']);
        
        if($res){
            $correcto = true;
        } else {
            $correcto = false;
        }
        
        echo json_encode(array("correcto" => $correcto));
    }
    
    /**
     * Formulario para nueva alarma
     */
    public function nueva(){
        $this->load->helper(array("modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"));
        $data = array("form_name" => "form_nueva");
        $this->load->view("pages/evento/form", $data);
    }
    
    /**
     * Formulario para editar alarma
     */
    public function editar(){
        $this->load->helper(array("modulo/emergencia/emergencia_form",
                                  "modulo/direccion/comuna"));
        $this->load->model('emergencia_model','EmergenciaModel');
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->EmergenciaModel->getById($params["id"]);

        if(!is_null($alarma)){
            $descripcion = $alarma->eme_c_descripcion;
            $informacion_adicional = $alarma->eme_c_informacion_adicional;
            $data = array("eme_id" => $alarma->eme_ia_id,
                          "nombre_informante"   => $alarma->eme_c_nombre_informante,
                          "nombre_emergencia"   => $alarma->eme_c_nombre_emergencia,
                          "id_tipo_emergencia"  => $alarma->tip_ia_id,
                          "id_estado_emergencia" => $alarma->est_ia_id,
                          "nombre_lugar"         => $alarma->eme_c_lugar_emergencia,
                          "observacion"          => $alarma->eme_c_observacion,
                          "informacion_adicional" => $informacion_adicional,
                          "descripcion" => $descripcion,
                          "fecha_emergencia" => ISODateTospanish($alarma->eme_d_fecha_emergencia),
                          "latitud_utm"  => $alarma->eme_c_utm_lat,
                          "longitud_utm" => $alarma->eme_c_utm_lng,
                          "nivel_emergencia" => $alarma->eme_nivel);
            
            if($alarma->est_ia_id == Emergencia_Estado_Model::EN_CURSO or $alarma->est_ia_id == Emergencia_Estado_Model::FINALIZADA){
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

            $this->load->view("pages/evento/form", $data);
        } else {
            show_404();
        }
    }
    
    /**
     * Formulario con datos relacionados a tipo emergencia
     */
    public function form_tipo_emergencia(){
        header('Content-type: application/json');
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
     * Activa la emergencia
     */
    public function ajax_activar_emergencia(){
        header('Content-type: application/json');
        $id_emergencia = $this->input->post('emergencia');

        $this->load->model('emergencia_model','EmergenciaModel');

        $json = array();
        $update = $this->EmergenciaModel->update(array('est_ia_id' => $this->EmergenciaModel->emergencia_activa),$id_emergencia);
        if($update){
            $json['estado'] = true;
            $json['mensaje'] = 'Emergencia en Curso';
            
            Evento_historial::putHistorial(
                $id_emergencia, 
                "El evento ha pasado a ser una Emergencia en Curso"
            );
            
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Problemas al activar la emergencia. Intente nuevamente';
        }

        echo json_encode($json);


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
        
        $this->load->view("pages/evento/grilla", array("lista" => $lista));
    }
    
    /**
     * Verifica datos generales
     */
    public function ajax_validar_datos_generales(){
        header('Content-type: application/json');
        $this->load->library(array("alarma/alarmavalidar"));
        
        $params = $this->input->post(null, true);

        $correcto = $this->alarmavalidar->esValido($params);
        $respuesta = array("correcto" => $correcto,
                           "error"    => $this->alarmavalidar->getErrores());
        
        echo json_encode($respuesta);
    }
}
