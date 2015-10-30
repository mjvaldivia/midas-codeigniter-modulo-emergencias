<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Alarma extends CI_Controller {

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
     * @var template
     */
    public $template;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper(array("session","utils"));
        $this->load->library(array("template"));
        $this->load->model("alarma_model", "AlarmaModel");
        $this->load->model("alarma_comuna_model", "AlarmaComunaModel");
        sessionValidation();
    }
    
    /**
     * Formulario de ingreso de alarma
     */
    public function ingreso() {
        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso.php")) {
            show_404();
        }

        $this->template->parse("default", "pages/alarma/ingreso", array());
    }

    /**
     * Guarda formulario de alarma
     */
    public function guardaAlarma() {
        if (!file_exists(APPPATH . "/views/pages/alarma/ingreso_paso_2.php")) {
            show_404();
        }
        
        $params = $this->input->post(null, true);
        
        $data = array(
                        "ala_c_nombre_informante"   => $params['iNombreInformante'],
                        "ala_c_telefono_informante" => $params['iTelefonoInformante'],
                        "ala_c_nombre_emergencia"   => $params['iNombreEmergencia'],
                        "tip_ia_id"                 => $params['iTiposEmergencias'],
                        "ala_c_lugar_emergencia" => $params['iLugarEmergencia'],
                        "ala_d_fecha_emergencia" => spanishDateToISO($params['fechaEmergencia']),
                        "rol_ia_id"              => $this->session->userdata('session_idCargo'),
                        "ala_d_fecha_recepcion"  => spanishDateToISO($params['fechaRecepcion']),
                        "usu_ia_id"              => $this->session->userdata('session_idUsuario'),
                        "est_ia_id"              => Alarma_Model::REVISION,
                        "ala_c_observacion"      => $params['iObservacion'],
                        "ala_c_utm_lat" => $params['ins_c_coordenada_n'],
                        "ala_c_utm_lng" => $params['ins_c_coordenada_e'],
                        "ala_c_geozone" => $params['geozone']
                       );

        $id = $this->AlarmaModel->query()->insert($data);
        
        foreach ($params['iComunas'] as $indice => $valor) {
            $this->AlarmaComunaModel->query()->insert(array("ala_ia_id" => $id,
                                                            "com_ia_id" => $valor));    
        }
        
        $respuesta = array("ala_ia_id" => $id,
                           "res_mail"  => "");
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
    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/alarma/listado.php")) {
            show_404();
        }

        $data = array(
            "anioActual" => date('Y')
        );

        $this->template->parse('alone',"pages/alarma/listado", $data);
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
        $this->load->model("alarma_model", "AlarmaModel");
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
