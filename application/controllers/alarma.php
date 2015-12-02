<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
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
        sessionValidation();
    }
    
    /**
     * Index
     */
    public function index(){
        $this->load->helper("modulo/direccion/comuna");
        $this->load->helper("modulo/alarma/alarma_form");
        $this->load->helper("modulo/emergencia/emergencia");
        $this->load->helper("modulo/emergencia/emergencia_form");
        
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
        
        $this->template->parse("default", "pages/alarma/inbox", $data);
    }
    
    
    public function form_nueva(){
        $this->load->helper(array("modulo/emergencia/emergencia_form","modulo/direccion/comuna"));
        $data = array("form_name" => "form_nueva");
        $this->load->view("pages/alarma/form", $data);
    }
    
    /**
     * Formulario para editar alarma
     */
    public function form_editar(){
        $this->load->helper(array("modulo/emergencia/emergencia_form","modulo/direccion/comuna"));
        
        $params = $this->uri->uri_to_assoc();
        $alarma = $this->AlarmaModel->getById($params["id"]);
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
     * Retorna grilla de alarmas
     */
    public function ajax_grilla_alarmas(){
        $this->load->helper(array("modulo/emergencia/emergencia"));
        $this->load->helper(array("modulo/alarma/alarma"));
        
        $params = $this->input->post(null, true);
        
        $lista = $this->AlarmaModel->buscar(array("id_estado" => $params["filtro_id_estado"],
                                                  "id_tipo"   => $params["filtro_id_tipo"],
                                                  "year"      => $params["filtro_year"]));
        
        $this->load->view("pages/alarma/grilla-alarmas", array("lista" => $lista));
    }
    
    /**
     * Formulario de ingreso de alarma
     */
    public function ingreso() {
        $this->load->helper("modulo/direccion/comuna");
        $this->load->helper("modulo/emergencia/emergencia");
        
        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso.php")) {
            show_404();
        }
        
        $datos['es_CRE'] = 0;
        if((int)$this->session->userdata('session_idCargo')==4){
            $datos['es_CRE'] = 1;
        }
        
        $datos["html_listado"] = $this->html_listado();
        
        $data["formulario"] = $this->load->view("pages/alarma/formularios/alarma", $datos, true);
        $this->template->parse("default", "pages/alarma/ingreso", $data);
    }
    
    /**
     * Formulario de edicion
     */
    public function editar() {
        $params = $this->uri->uri_to_assoc();
        $datos['ala_ia_id'] = $params['id'];

        $data["formulario"] = $this->load->view("pages/alarma/formularios/alarma", $datos, true);
        /*$this->template->parse("default", "pages/alarma/editar", $data);*/
        $this->load->view("pages/alarma/editar", $data);
    }
    
    public function getAlarma() {
        $params = $this->uri->uri_to_assoc();
        $this->load->model("alarma_model", "AlarmaModel");
        return $this->AlarmaModel->getJsonAlarma($params);
    }

    /**
     * Guarda formulario de alarma
     */
    public function guardaAlarma() {       
         $this->load->library(array("alarma/alarmavalidar"));
        
        $params = $this->input->post(null, true);
        
        $correcto = true;
        $error = array();
        
        
        $correcto = $this->alarmavalidar->esValido($params);
        $respuesta = array();
        if($correcto){
        
        
            $data = array(
                            "ala_c_nombre_informante"   => $params['nombre_informante'],
                            "ala_c_telefono_informante" => $params['telefono_informante'],
                            "ala_c_nombre_emergencia"   => $params['nombre_emergencia'],
                            "tip_ia_id"                 => $params['tipo_emergencia'],
                            "ala_c_lugar_emergencia" => $params['nombre_lugar'],
                            "ala_d_fecha_emergencia" => spanishDateToISO($params['fecha_emergencia']),
                            "rol_ia_id"              => $this->session->userdata('session_idCargo'),
                            "ala_d_fecha_recepcion"  => spanishDateToISO($params['fecha_recepcion']),
                            "usu_ia_id"              => $this->session->userdata('session_idUsuario'),
                            "ala_c_observacion"      => $params['observacion'],
                            "ala_c_utm_lat" => $params['latitud'],
                            "ala_c_utm_lng" => $params['longitud'],
                            "ala_c_geozone" => $params['geozone']
                           );

            $alerta = $this->AlarmaModel->query()->getById("ala_ia_id", $params["id"]);

            //la alarma ya existia
            if(!is_null($alerta)){

                $id= $alerta->ala_ia_id;
                $this->AlarmaModel->query()->update($data, "ala_ia_id", $alerta->ala_ia_id);
                $this->AlarmaComunaModel->query()->insertOneToMany("ala_ia_id", "com_ia_id", $alerta->ala_ia_id, $params['comunas']);
                $respuesta_email = "";
            //la alarma no existia
            } else {
                $data["est_ia_id"] = Alarma_Model::REVISION;
                $id = $this->AlarmaModel->query()->insert($data);
                $this->AlarmaComunaModel->query()->insertOneToMany("ala_ia_id", "com_ia_id", $id, $params['comunas']);
                $params["ala_ia_id"] = $id;
                $respuesta_email = $this->AlarmaModel->enviaCorreo($params);
            }
            
            

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

    /**
     * retorna lista
     */
    public function html_listado() {
        $params = $this->uri->uri_to_assoc();
        $this->load->helper(array("modulo/alarma/alarma_form"));
        
        
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
            "select_estado_id_default" => $id_estado,
            "anioActual" => date('Y')
        );
         // var_dump($data);die;
        return $this->load->view("pages/alarma/listado", $data, true);
    }

    /**
     * Retorna lista de alarmas
     */
    public function jsonAlarmasDT() {
        $params = $this->uri->uri_to_assoc();
        $alarmas = $this->AlarmaModel->filtrarAlarmas($params);

        $json["data"] = $alarmas;
        $json["columns"] = array(
            array("sTitle" => "Alarmas"),
        );

        echo json_encode($json);
    }

    /**
     * Retorna tipos de emergencias
     */
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

    /**
     * Retorna estados de la alarma
     */
    public function jsonEstadosAlarmas() {
        $estados = $this->AlarmaModel->obtenerEstados();

        $json = array();
        foreach ($estados as $e) {
            $json[] = array(
                $e["est_ia_id"],
                $e["est_c_nombre"],
            );
        }

        echo json_encode($json);
    }
    
    /**
     * 
     */
    public function paso2() {

        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso_paso_2.php")) {
            show_404();
        }

        $params = $this->uri->uri_to_assoc();

        $data['ala_ia_id'] = $params['id'];
        $data['tipoAlarma'] = $params['tip_ia_id'];
        switch ($params['tip_ia_id']){
            case 15: $data["formulario"] = $this->template->parse("pages/alarma/formularios/radiologico", $data, true);
                break;   
        }
        
        $this->template->parse("default", "pages/alarma/ingreso_paso_2", $data);
    }

}
