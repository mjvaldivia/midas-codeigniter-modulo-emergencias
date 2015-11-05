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
    
    /**
     * Index-
     */
    public function index () {
        
        if ( ! file_exists(APPPATH.'/views/pages/home/index.php')){
            show_404();
        }
        $fecha_hasta = New DateTime("Now");
        $fecha_desde = New DateTime("Now");
        $fecha_desde->sub(new DateInterval('P30D'));
        
        $this->template->parse("default", "pages/home/index", array("grilla_emergencia" => "",
                                                                    "fecha_desde" => $fecha_desde->format("d/m/Y"),
                                                                    "fecha_hasta" => $fecha_hasta->format("d/m/Y")));
    }
    
    /**
     * 
     */
    public function ajax_grilla_alarmas(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("d/m/Y", $params["desde"]);
        $fecha_hasta = DateTime::createFromFormat("d/m/Y", $params["hasta"]);
        echo $this->_html_grilla_alarmas($fecha_desde, $fecha_hasta);
    }
    
    /**
     * 
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     */
    protected function _html_grilla_alarmas($fecha_desde, $fecha_hasta){
        $this->load->helper(array("modulo/emergencia/emergencia"));
        $this->load->helper(array("modulo/alarma/alarma"));
        $lista = $this->AlarmaModel->listarAlarmasEntreFechas($fecha_desde, $fecha_hasta);
        return $this->load->view("pages/home/grilla_alarmas", array("lista" => $lista), true);
    }
    
    /**
     * 
     */
    public function ajax_grilla_emergencias(){
        $params = $this->input->post(null, true);
        $fecha_desde = DateTime::createFromFormat("d/m/Y", $params["desde"]);
        $fecha_hasta = DateTime::createFromFormat("d/m/Y", $params["hasta"]);
        echo $this->_html_grilla_emergencias($fecha_desde, $fecha_hasta);
    }
    
    /**
     * 
     * @param DateTime $fecha_desde
     * @param DateTime $fecha_hasta
     */
    protected function _html_grilla_emergencias($fecha_desde, $fecha_hasta){
        $this->load->helper(array("modulo/emergencia/emergencia"));
        $lista = $this->EmergenciaModel->listarEmergenciasEntreFechas($fecha_desde, $fecha_hasta);
        return $this->load->view("pages/home/grilla_emergencias", array("lista" => $lista), true);
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
    
    /**
     * Carga las alertas al calendario
     */
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
    
    /**
     * Carga las emergencias al calendario
     */
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
    
    /**
     * Devuelve datos para grafico de emergencias
     * de mes por año
     */
    public function json_cantidad_emergencia_mes(){
        $lista_years = $this->EmergenciaModel->listarYearsConEmergencias();
        $data = array();
        $label_ano = array();
        $xkeys = array();
        
        for($i=0; $i<12; $i++){
            
            $data_year = array();
            $indice = 0;
            foreach($lista_years as $year){
                if($year["ano"]!=0){
                    
                    if(array_search($year["ano"], $label_ano) === false){
                        $label_ano[] = $year["ano"];
                    }
                    
                    if(array_search($indice, $xkeys) === false){
                        $xkeys[] = $indice;
                    }
                    
                    $data_year[$indice] = $this->EmergenciaModel->cantidadEmergenciasMes($i+1, $year["ano"]);
                    $indice++;
                }
            }

            $data[] = array_merge(array("m" => "2015-" . $this->_corrigeNumeroMes($i+1)), $data_year );
    
        }
        
        $respuesta = array("correcto" => true,
                           "ykeys" => $xkeys,
                           "labels" => $label_ano,
                           "data" => $data);
        echo json_encode($respuesta);
    }
    
    /**
     * Formato para el mes
     * @param int $mes
     * @return string
     */
    protected function _corrigeNumeroMes($mes){
        if($mes < 10){
            return "0" . (string) $mes;
        } else {
            return (string) $mes;
        }
    }
}