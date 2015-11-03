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
     * @var template
     */
    public $template;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->model("alarma_model", "AlarmaModel");
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
    
    public function json_cantidad_emergencia(){
        
    }
}