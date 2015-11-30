<?php
if (!defined("BASEPATH")) exit("No direct script access allowed");
/**
 * User: claudio
 * Date: 15-09-15
 * Time: 10:55 AM
 */


class Capas extends MY_Controller 
{
    /**
     *
     * @var Usuario 
     */
    public $usuario;
    
    /**
     *
     * @var Capa_Model
     */
    public $capa_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        sessionValidation();
        $this->load->library("usuario");
        $this->load->model("capa_model", "capa_model");
        $this->usuario->setModulo("capas");
    }
    
    public function index() {
        if (!file_exists(APPPATH . "/views/pages/capa/index.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        $data = array();

        $this->template->parse("default", "pages/capa/index", $data);
    }

    public function ingreso() {
        if (!file_exists(APPPATH . "/views/pages/capa/ingreso.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $this->load->library(array("template"));

        
        
        if($this->usuario->getPermisoEditar()){
            if(isset($params["tab"])){
                $tab = $params["tab"];
            } else {
                $tab = "nuevo";
            }
        } else {
            $tab = "listado";
        }
        
        $data = array(
            "editar" => false,
            "tab_activo" => $tab
        );

        $this->template->parse("default", "pages/capa/ingreso", $data);
    }
    public function listado() {
        if (!file_exists(APPPATH . "/views/pages/capa/listado.php")) {
            // Whoops, we don"t have a page for that!
            show_404();
        }

        // load basicos
        $this->load->library("template");
        $this->load->helper("session");

        sessionValidation();
        $data = array(
            
        );

        $this->template->parse('alone',"pages/capa/listado",$data);
    }
    
    
    function ajax_grilla_capas() {
        $this->load->helper(array("modulo/capa/capa","file"));
        $lista = $this->capa_model->listarCapas();
        $this->load->view("pages/capa/grilla_capas", array("lista" => $lista));
    }


    public function validarCapaEmergencia(){
        $this->load->helper(array("session", "debug"));
        $id_capa = $this->input->post('capa');

        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->validarCapaEmergencia($id_capa) > 0){
            $json['estado'] = true;
        }else{
            $json['estado'] = false;
        }

        echo json_encode($json);
    }


    public function eliminarCapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_capa = $this->input->post('capa');

        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->eliminarCapa($id_capa)){
            $json['estado'] = true;
            $json['mensaje'] = 'La capa ha sido eliminada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al eliminar la capa. Intente nuevamente';
        }

        echo json_encode($json);
    }


    public function editarCapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_capa = $this->input->post('capa');
        $this->load->model("capa_model", "CapaModel");

        $this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $categorias = array();

        foreach ($CategoriaCobertura as $c) {
            $categorias[] = array(
                'categoria_id' => $c["ccb_ia_categoria"],
                'categoria_nombre' => $c["ccb_c_categoria"]
            );
        }

        $this->load->model('comuna_model','ComunaModel');
        $comunas = $this->ComunaModel->getComunasPorRegion($this->session->userdata['session_region_codigo']);

        $capa = $this->CapaModel->getCapa($id_capa);

        /** leer geojson asociado **/
        $properties = array();
        $tmp_prop_array = array();

        
        $fp = file_get_contents($capa->capa,'r');
        
        $arr_properties = json_decode($fp,true);
        
        foreach ($arr_properties['features'][0]['properties'] as $k => $v) {

            if (in_array($k, $tmp_prop_array)) { // reviso que no se me repitan las propiedades
                continue;
            }
            $properties[] = $k;
            $tmp_prop_array[] = $k;
        }
         
        $data = array(
            'id_capa' => $id_capa,
            'capa' => $capa,
            'categorias' => $categorias,
            'comunas' => $comunas,
            'geojson' => $properties
            );
        echo $this->load->view("pages/capa/edicion",$data);
    }
    
}