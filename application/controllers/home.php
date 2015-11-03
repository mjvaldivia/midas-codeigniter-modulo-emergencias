<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 12-08-15
 * Time: 04:24 PM
 */
class Home extends CI_Controller{
    
    /**
     *
     * @var Alarma_Model
     */
    public $AlarmaModel;
    
    /**
     *
     * @var Emergencia_Model 
     */
    public $EmergenciaModel;

    /**
     *
     * @var template
     */
    public $template;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("alarma_model", "AlarmaModel");
        $this->load->model("emergencia_model", "EmergenciaModel");
        $this->load->helper(array("session","utils"));
        $this->load->library(array("template"));
        sessionValidation();
    }
    
    
    public function index () {
        if ( ! file_exists(APPPATH.'/views/pages/home.php')){
            show_404();
        }
        
        $fecha_hasta = New DateTime("Now");
        $fecha_desde = New DateTime("Now");
        $fecha_desde->sub(new DateInterval('P30D'));
        
        $this->template->parse("default", "pages/home", array("fecha_desde" => $fecha_desde->format("d/m/Y"),
                                                              "fecha_hasta" => $fecha_hasta->format("d/m/Y")));
    }
    
    /**
     * Cantidad de alarmas entre fechas
     */
    public function json_cantidad_alarmas(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("d/m/Y", $params["desde"]);
        $fecha_hasta = DateTime::createFromFormat("d/m/Y", $params["hasta"]);
        $cantidad = $this->AlarmaModel->cantidadAlarmas($fecha_desde, $fecha_hasta);
        
        $respuesta = array("correcto" => true,
                           "cantidad"  => $cantidad);
        echo json_encode($respuesta);
    }
    
    /**
     * Cantidad de emergencias entre fechas
     */
    public function json_cantidad_emergencia(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("d/m/Y", $params["desde"]);
        $fecha_hasta = DateTime::createFromFormat("d/m/Y", $params["hasta"]);
        $cantidad = $this->EmergenciaModel->cantidadEmergencias($fecha_desde, $fecha_hasta);
        
        $respuesta = array("correcto" => true,
                           "cantidad"  => $cantidad);
        echo json_encode($respuesta);
    }
    
    public function json_eventos_calendario_alertas(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("Y-m-d", $params["start"]);
        $fecha_hasta = DateTime::createFromFormat("Y-m-d", $params["end"]);
        
        
        $respuesta = array();
        
        $lista_alertas = $this->AlarmaModel->listarAlarmasEntreFechas($fecha_desde, $fecha_hasta);
        if(!is_null($lista_alertas)){
            foreach($lista_alertas as $key => $alerta){
                
                $fecha_alerta = DateTime::createFromFormat("Y-m-d H:i:s", $alerta["ala_d_fecha_emergencia"]);
                
                $respuesta[] = array("title" => $alerta["ala_c_nombre_emergencia"],
                                     "start" => $fecha_alerta->format("Y-m-d H:i:s"),
                                     "allDay" => false);
            }
        }
        echo json_encode($respuesta);
    }
    
    public function json_eventos_calendario_emergencias(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("Y-m-d", $params["start"]);
        $fecha_hasta = DateTime::createFromFormat("Y-m-d", $params["end"]);
        
        
        $respuesta = array();
        
        $lista_alertas = $this->EmergenciaModel->listarEmergenciasEntreFechas($fecha_desde, $fecha_hasta);
        if(!is_null($lista_alertas)){
            foreach($lista_alertas as $key => $alerta){
                
                $fecha_alerta = DateTime::createFromFormat("Y-m-d H:i:s", $alerta["eme_d_fecha_emergencia"]);
                
                $respuesta[] = array("title" => $alerta["eme_c_nombre_emergencia"],
                                     "start" => $fecha_alerta->format("Y-m-d H:i:s"),
                                     "allDay" => false);
            }
        }
        echo json_encode($respuesta);
    }
}