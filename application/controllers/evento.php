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
    public $_emergencia_model;
    
    /**
     *
     * @var Emergencia_Comuna_Model 
     */
    public $_emergencia_comuna_model;
    
    /**
     *
     * @var Emergencia_Estado_Model 
     */
    public $_emergencia_estado_model;
    
    /**
     *
     * @var Tipo_Emergencia_Model 
     */
    public $_emergencia_tipo_model;
    
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
        
        $this->load->model('emergencia_model','_emergencia_model');
        $this->load->model("emergencia_comuna_model", "_emergencia_comuna_model");
        $this->load->model("emergencia_estado_model", "_emergencia_estado_model");
        $this->load->model("tipo_emergencia_model", "_emergencia_tipo_model");
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
       
        $data = array(
            "year" => date('Y')
        );
        
        $this->template->parse("default", "pages/evento/index", $data);
    }
    
    /**
     * Bitacora
     */
    public function expediente(){
        $this->load->helper(array("modulo/usuario/usuario",
                                  "modulo/archivo/archivo",
                                  "modulo/alarma/alarma",
                                  "modulo/emergencia/emergencia",
                                  "modulo/emergencia/emergencia_grilla"));

        $params = $this->uri->uri_to_assoc();
        
        $emergencia = $this->_emergencia_model->getById($params['id']);
        if(!is_null($emergencia)){
            $data = array(
                'emergencia' => $emergencia,
            );

            $this->load->view('pages/evento/expediente',$data);
        }
    }
    
    /**
     * Guarda formulario de alarma
     */
    public function guardar() { 
        header('Content-type: application/json');
        $this->load->helper(array("modulo/alarma/alarma"));
        $this->load->library(array("alarma/alarma_validar",
                                   "emergencia/email/emergencia_email_revision"));
        
        
        $se_envia_email = false;
        
 
        $params = $this->input->post(null, true);

        if($this->alarma_validar->esValido($params)){

            $data = array(
                "eme_c_nombre_informante" => $params['nombre_informante'],
                "eme_c_nombre_emergencia" => $params['nombre_emergencia'],
                "tip_ia_id"               => $params['tipo_emergencia'],
                "est_ia_id"               => $params['estado_emergencia'],
                "eme_c_lugar_emergencia"  => $params['nombre_lugar'],
                "eme_d_fecha_emergencia"  => spanishDateToISO($params['fecha_emergencia']),
                "rol_ia_id"          => $this->session->userdata('session_idCargo'),
                "usu_ia_id"          => $this->session->userdata('session_idUsuario'),
                "eme_c_descripcion"  => $params['descripcion_emergencia'],
                "eme_c_observacion"  => $params['observacion'],
                "eme_c_utm_lat" => $params['latitud'],
                "eme_c_utm_lng" => $params['longitud'],
                "eme_nivel" => $params['nivel_emergencia']
            );

            $evento = $this->_emergencia_model
                           ->query()
                           ->getById("eme_ia_id", $params["eme_id"]);

            //la alarma ya existia
            if(!is_null($evento)){
                $id = $evento->eme_ia_id;
                
                $this->_emergencia_model
                     ->update(
                        $data, 
                        $evento->eme_ia_id
                     );
               
            } else {
                $data["eme_d_fecha_recepcion"] = DATE("Y-m-d H:i:s");
                
                $data["hash"] = $this->_nuevoHash();
                
                $id = $this->_emergencia_model
                           ->insert($data);
                
                $se_envia_email = $this->_enviaEmail($id);

                Evento_historial::putHistorial(
                    $id, 
                    'Se ha creado el Evento con estado ' . nombreAlarmaEstado($params['estado_emergencia']) 
                );
            }
            
            $this->_emergencia_comuna_model
                 ->query()
                 ->insertOneToMany(
                    "eme_ia_id", 
                    "com_ia_id", 
                    $id, 
                    $params['comunas']
                 );

            $this->_guardarFormularioTipoEmergencia($id);
            $this->_guardarArchivos($id,$this->session->userdata('session_idUsuario'));
        }

        $respuesta = array(
            "se_envia_email" => $se_envia_email,
            "correcto" => $this->alarma_validar->getCorrecto(),
            "error" => $this->alarma_validar->getErrores()
        );

        echo Zend_Json::encode($respuesta);
    }
    
    /**
     * Elimina emergencia
     */
    public function eliminar() { 
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $res = $this->_emergencia_model->delete($params['id']);
        
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
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->_emergencia_model->getById($params["id"]);

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


            $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($alarma->eme_ia_id);
            
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
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
        
        $user_data = array(
            'nombre' => $this->session->userdata('session_nombres'),
            'cargo' => $this->session->userdata('session_cargo'),
            'email' => $this->session->userdata('session_email')
          );
        $formulario['data']['investigador'] = $user_data;
       

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

        $json = array();
        $update = $this->_emergencia_model->update(
                array('est_ia_id' => Emergencia_Estado_Model::EN_CURSO),
                $id_emergencia
        );
        
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
     * 
     */
    public function ajax_comunas_emergencia(){
        header('Content-type: application/json');
        $params = $this->input->post(null, true);
        $lista_comunas = $this->_emergencia_comuna_model->listaComunasPorEmergencia($params["id"]);
        $respuesta = array("correcto" => true,
                           "comunas" => $lista_comunas,
                           "error"    => array());
        
        echo json_encode($respuesta);
    }
    
    /**
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_alarmas(){
        $this->load->helper(array("modulo/emergencia/emergencia",
                                  "modulo/alarma/alarma"));

        $params = $this->input->post(null, true);
        
        $lista = $this->_emergencia_model->buscar(
            array("id_estado" => $params["filtro_id_estado"],
                  "id_tipo"   => $params["filtro_id_tipo"],
                  "year"      => $params["filtro_year"],
                  "nivel" => $params['filtro_nivel'])
        );
        
        $this->load->view("pages/evento/grilla", array("lista" => $lista));
    }
    
    /**
     * Verifica datos generales
     */
    public function ajax_validar_datos_generales(){
        header('Content-type: application/json');
        $this->load->library(array("alarma/alarma_validar"));
        
        $params = $this->input->post(null, true);

        $respuesta = array("correcto" => $this->alarma_validar->esValido($params),
                           "error"    => $this->alarma_validar->getErrores());
        
        echo json_encode($respuesta);
    }
    
    /**
     * 
     * @param int $id
     * @return boolean
     */
    protected function _enviaEmail($id){
        $se_envia_email = false;
        $params = $this->input->post(null, true);
        //envio de email
        if(count($params["destinatario"])>0){
            $this->emergencia_email_revision->setEmergencia($id);

            foreach($params["destinatario"] as $email){
                $this->emergencia_email_revision->addTo($email);
            }

            $this->emergencia_email_revision->enviar();

            $se_envia_email = $this->emergencia_email_revision->boSeEnviaEmail();
        }
        
        return $se_envia_email;
    }
    
    /**
     * Guarda el fomulario especial para tipo de emergencia
     * @param int $id
     */
    protected function _guardarFormularioTipoEmergencia($id){
        $this->load->library(array("emergencia/emergencia_guardar"));
        
        $params = $this->input->post(null, true);
        
        $this->emergencia_guardar->setEmergencia($id);
        $this->emergencia_guardar->setTipo($params["tipo_emergencia"]);
        $this->emergencia_guardar->guardarDatosTipoEmergencia($params);
    }
    
    /**
     * Guarda archivos adjuntos
     * @param int $id_evento
     */
    protected function _guardarArchivos($id_evento,$id_usuario){
        $this->load->library("evento/evento_archivo");
        
        $params = $this->input->post(null, true);
        
        $this->evento_archivo->setEvento($id_evento);
        if(count($params["archivos"])>0){
            foreach($params["archivos"] as $key => $id_archivo){
                $this->evento_archivo->addArchivo(
                    $params["archivos_hash"][$key], 
                    $params["archivos_descripcion"][$key],
                    $params["archivos_tipo"][$key], 
                    $id_archivo,
                    $id_usuario
                );
            }
        }
        
        $this->evento_archivo->guardar();
    }


    public function listaFuentesRadiologicas(){
        $this->load->model('Fuentes_Radiologicas_model','FuentesRadiologicasModel');

        $listado = $this->FuentesRadiologicasModel->getListadoFuentes();

        $data = array('listado_fuentes'=>$listado);

        $this->load->view("pages/evento/listado_fuentes_radiologicas", $data);
    }


    public function cargarFuentesRadiologicas(){
        $file = 'media/fuentes_radiologicas.csv';

        $file = fopen($file,"r");
        $this->load->model('Fuentes_Radiologicas_model','FuentesRadiologicasModel');
        while(($data = fgetcsv($file , 0 , ";")) !== FALSE){
          if(!empty($data[1])){
              $datos = array(
              'nombre_empresa_fuente' => $data[1],
              'rut_empresa_fuente' => $data[2],
              'comuna_empresa_fuente' => mb_strtoupper($data[8]),
              'tipo_fuente' => $data[9],
              'actividad_fuente' => $data[10],
              'numero_serie_fuente' => $data[15],
              'marca_fuente' => $data[16],
              'coordenadax_fuente' => $data[21],
              'coordenaday_fuente' => $data[22]
              );

              $insertar = $this->FuentesRadiologicasModel->insert($datos);  
          }
          
        }
    }


    public function infoFuenteRadiologica(){
        $id_fuente = $this->input->post('fuente');

        $this->load->model('Fuentes_Radiologicas_model','FuentesRadiologicasModel');

        $data_fuente = $this->FuentesRadiologicasModel->getById($id_fuente);
        if($data_fuente){
            $json['info'] = $data_fuente;
            $json['estado'] = true;
        }else{
            $json['estado'] = false;
            $json['mensaje'];
        }  
        
        echo json_encode($json);
    }
    
    /**
     * Genera nuevo HASH para el evento
     * este hash permite acceder al mapa de forma publica
     * @return string
     */
    protected function _nuevoHash(){
        $this->load->library("core/string/random");
        $hash = $this->random->rand_string(45);
        
        $existe = $this->_emergencia_model->getByHash($hash);
        if(!is_null($existe)){
            return $this->_nuevoHash();
        } else {
            return $hash;
        }
    }
    
    /**
     * Regenera el hash para todos los eventos
     */
    
    /*public function regeneraHash(){
        $lista = $this->_emergencia_model->listar();
        foreach($lista as $emergencia){
            $hash = $this->_nuevoHash();
            $data["hash"] = $hash;
            $this->_emergencia_model->update($data, $emergencia["eme_ia_id"]);
        }
    }*/
}
