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
        $this->load->model("alarma_comuna_model", "AlarmaComunaModel");
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
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->AlarmaModel->getById($params["id"]);
        if(!is_null($alarma)){
            
            $data = array("ala_id" => $alarma->ala_ia_id,
                          "nombre_informante"   => $alarma->ala_c_nombre_informante,
                          "telefono_informante" => $alarma->ala_c_telefono_informante,
                          "nombre_emergencia"   => $alarma->ala_c_nombre_emergencia,
                          "id_tipo_emergencia"  => $alarma->tip_ia_id,
                          "nombre_lugar"        => $alarma->ala_c_lugar_emergencia,
                          "observacion"         => $alarma->ala_c_observacion,
                          "fecha_emergencia"    => ISODateTospanish($alarma->ala_d_fecha_emergencia),
                          "geozone"             => $alarma->ala_c_geozone,
                          "latitud_utm"  => $alarma->ala_c_utm_lat,
                          "longitud_utm" => $alarma->ala_c_utm_lng);
            
            $lista_comunas = $this->AlarmaComunaModel->listaComunasPorAlarma($alarma->ala_ia_id);
            
            foreach($lista_comunas as $comuna){
                $data["lista_comunas"][] = $comuna["com_ia_id"];
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
        
        $params = $this->input->post(null, true);
        
        $lista = $this->AlarmaModel->buscar(array("id_estado" => $params["filtro_id_estado"],
                                                  "id_tipo"   => $params["filtro_id_tipo"],
                                                  "year"      => $params["filtro_year"]));
        
        $this->load->view("pages/alarma/grilla/grilla-alarmas", array("lista" => $lista));
    }
 
    /**
     * Guarda formulario de alarma
     */
    public function guardaAlarma() {       
        $this->load->library(array("alarma/alarmavalidar", 
                                   "alarma/alarma_guardar"));
        
        $params = $this->input->post(null, true);
        
        $respuesta = array();
        $correcto = $this->alarmavalidar->esValido($params);
        
        if($correcto){
        
        
            $data = array(
                            "ala_c_nombre_informante"   => $params['nombre_informante'],
                            "ala_c_telefono_informante" => $params['telefono_informante'],
                            "ala_c_nombre_emergencia"   => $params['nombre_emergencia'],
                            "tip_ia_id"                 => $params['tipo_emergencia'],
                            "ala_c_lugar_emergencia" => $params['nombre_lugar'],
                            "ala_d_fecha_emergencia" => spanishDateToISO($params['fecha_emergencia']),
                            "rol_ia_id"              => $this->session->userdata('session_idCargo'),
                            "usu_ia_id"              => $this->session->userdata('session_idUsuario'),
                            "ala_c_observacion"      => $params['observacion'],
                            "ala_c_utm_lat" => $params['latitud'],
                            "ala_c_utm_lng" => $params['longitud'],
                            "ala_c_geozone" => $params['geozone']
                           );

            $alerta = $this->AlarmaModel->query()->getById("ala_ia_id", $params["ala_id"]);

            //la alarma ya existia
            if(!is_null($alerta)){

                $id= $alerta->ala_ia_id;
                $this->AlarmaModel->query()->update($data, "ala_ia_id", $alerta->ala_ia_id);
                $this->AlarmaComunaModel->query()->insertOneToMany("ala_ia_id", "com_ia_id", $alerta->ala_ia_id, $params['comunas']);
                $respuesta_email = "";
            //la alarma no existia
            } else {
                $data["ala_d_fecha_recepcion"] = DATE("Y-m-d H:i:s");
                $data["est_ia_id"] = Alarma_Model::REVISION;
                $id = $this->AlarmaModel->query()->insert($data);
                $this->AlarmaComunaModel->query()->insertOneToMany("ala_ia_id", "com_ia_id", $id, $params['comunas']);
                $params["ala_ia_id"] = $id;
                $respuesta_email = $this->AlarmaModel->enviaCorreo($params);
            }
            
            $this->alarma_guardar->setAlarma($id);
            $this->alarma_guardar->setTipo($params["tipo_emergencia"]);
            $this->alarma_guardar->guardarDatosTipoEmergencia($params);

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


}
