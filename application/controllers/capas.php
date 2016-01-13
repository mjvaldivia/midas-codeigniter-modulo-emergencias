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
    
    
    function ajax_grilla_capas_unicas() {
        $this->load->helper(array("modulo/capa/capa","file"));
        $lista = $this->capa_model->listarCapasUnicas();
        $this->load->view("pages/capa/grilla_capas", array("lista" => $lista));
    }

    function ajax_grilla_capas() {
        $id_capa = $this->input->post('id_capa');
        $this->load->helper(array("modulo/capa/capa","file"));
        $lista = $this->capa_model->listarCapas($id_capa);
        $this->load->view("pages/capa/grilla_capas_detalle", array("lista" => $lista));
    }


    function ajax_grilla_items_subcapas() {
        $id_subcapa = $this->input->post('subcapa');
        $this->load->helper(array("modulo/capa/capa"));

        $arr_items = array();
        $arr_cabeceras = array();
        $subcapa = $this->capa_model->getSubCapa($id_subcapa);

        $arr_cabeceras = explode(",",$subcapa['cap_c_propiedades']);
        $lista = $this->capa_model->listarItemsSubCapas($id_subcapa);
        if($lista){
            foreach($lista as $item){
                $arr_propiedades = array();
                $propiedades = unserialize($item['poligono_propiedades']);
                foreach($arr_cabeceras as $cabecera){
                    $arr_propiedades[] = $propiedades[$cabecera];
                }
                $arr_items[] = array(
                    'comuna' => $item['com_c_nombre'],
                    'provincia' => $item['prov_c_nombre'],
                    'region' => $item['reg_c_nombre'],
                    'id' => $item['poligono_id'],
                    'propiedades' => $arr_propiedades
                );
            }
        }


        $this->load->view("pages/capa/grilla_capas_items_subcapa", array("lista" => $arr_items, "cabeceras" => $arr_cabeceras));
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


    public function validarSubCapaEmergencia(){
        $this->load->helper(array("session", "debug"));
        $id_capa = $this->input->post('capa');

        sessionValidation();
        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->validarSubCapaEmergencia($id_capa) > 0){
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


    public function eliminarSubCapa(){
        $this->load->helper(array("session", "debug"));
        sessionValidation();

        $id_subcapa = $this->input->post('subcapa');

        $this->load->model("capa_model", "CapaModel");
        $json = array();

        if($this->CapaModel->eliminarSubCapa($id_subcapa)){
            $json['estado'] = true;
            $json['mensaje'] = 'La subcapa ha sido eliminada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al eliminar la subcapa. Intente nuevamente';
        }

        echo json_encode($json);
    }


    public function editarCapa(){


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

        
        $fp = file_get_contents(base_url($capa->capa,'r'));
        
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


    public function editarSubCapa(){
        $id_capa = $this->input->post('capa');
        $this->load->model("capa_model", "CapaModel");

        /*$this->load->model("categoria_cobertura_model", "CategoriaCobertura");

        $CategoriaCobertura = $this->CategoriaCobertura->obtenerTodos();

        $categorias = array();

        foreach ($CategoriaCobertura as $c) {
            $categorias[] = array(
                'categoria_id' => $c["ccb_ia_categoria"],
                'categoria_nombre' => $c["ccb_c_categoria"]
            );
        }

        $this->load->model('comuna_model','ComunaModel');
        $comunas = $this->ComunaModel->getComunasPorRegion($this->session->userdata['session_region_codigo']);*/

        $capa = $this->CapaModel->getSubCapa($id_capa);

        /** leer geojson asociado **/
        /*$properties = array();
        $tmp_prop_array = array();


        $fp = file_get_contents(base_url($capa->capa,'r'));

        $arr_properties = json_decode($fp,true);

        foreach ($arr_properties['features'][0]['properties'] as $k => $v) {

            if (in_array($k, $tmp_prop_array)) { // reviso que no se me repitan las propiedades
                continue;
            }
            $properties[] = $k;
            $tmp_prop_array[] = $k;
        }*/
        $this->load->helper(array("modulo/capa/capa"));
        $data = array(
            'id_capa' => $id_subcapa,
            'capa' => $capa
        );
        echo $this->load->view("pages/capa/edicion_subcapa",$data);
    }


    public function subir_CapaIconTemp(){
        $error = false;
        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();
        if (!isset($_FILES)) {
            show_error("No se han detectado archivos", 500, "Error interno");
        }

        $tmp_name = $_FILES['input_icono_subcapa']['tmp_name'];
        $nombres = $_FILES['input_icono_subcapa']['name'];
        $size = $_FILES['input_icono_subcapa']['size'];
        $type = $_FILES['input_icono_subcapa']['type'];

        $fp = file_get_contents($tmp_name, 'r');


        $nombre_cache_id = 'icon_subcapa_temp_'.  uniqid();
        $binary_path = ('media/tmp/'.$nombre_cache_id);
        $ftmp = fopen($binary_path, 'w');
        fwrite($ftmp, $fp);

        $arr_cache= array(
            'filename' => $nombres,
            'nombre_cache_id' => $nombre_cache_id,
            'content' => $fp,
            'size'=> $size,
            'type'=> $type

        );
        $this->cache->save($nombre_cache_id, $arr_cache, 28800);

        echo json_encode(array("uploaded" => 1, 'nombre_cache_id' => $nombre_cache_id, 'ruta'=>base_url($binary_path)));
    }



    public function guardarSubCapa(){
        $params = $this->input->post();
        $this->load->model('capa_model','CapaModel');

        $this->load->helper(array("session", "debug"));
        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        sessionValidation();

        $guardar = $this->CapaModel->guardarSubCapa($params);
        $json = array();
        if($guardar){
            $json['estado'] = true;
            $json['mensaje'] = 'Subcapa guardada';
        }else{
            $json['estado'] = false;
            $json['mensaje'] = 'Hubo un problema al guardar la subcapa. Intente nuevamente';
        }

        echo json_encode($json);


    }

    
}