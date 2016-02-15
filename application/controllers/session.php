<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:58 AM
 */
class Session extends MY_Controller {
    
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
     * @var Rol_Model 
     */
    public $rol_model;
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
        $this->load->library("usuario");
        $this->load->model("rol_model", "rol_model");
    }
    
    /**
     * Inicia el modo simulacion
     */
    public function inicia_simulacion(){
        $this->enviroment->setSimulacion();
        header("location: " . base_url());
        die();
    }
    
    /**
     * Inicia el modo simulacion
     */
    public function termina_simulacion(){
        $this->enviroment->clearSimulacion();
        header("location: " . base_url());
        die();
    }
    
    /**
     * Esta en simulacion o no
     */
    public function ajax_simulacion(){
        $ambiente = $this->enviroment->getDatabase();
        if($ambiente == "simulacion"){
            $respuesta = true;
        } else {
            $respuesta = false;
        }
        
        echo json_encode(array("simulacion" => $respuesta));
    }
    
    /**
     * Ve si el usuario tiene permisos para editar
     */
    public function json_permisos(){
        $params = $this->input->post(null, true);

        $this->usuario->setModulo($params["modulo"]);
        
        $retorno = array("ver"    => $this->usuario->getPermisoVer(),
                         "editar" => $this->usuario->getPermisoEditar(),
                         "nuevo"  => $this->usuario->getPermisoEditar(),
                         "eliminar" => $this->usuario->getPermisoEliminar(),
                         "finalizar_emergencia" => $this->usuario->getPermisoFinalizarEmergencia());
        
        
        $retorno["correcto"] = true;
        
        echo json_encode($retorno);
    }
    
    public function obtenerJsonComunas() {
        $this->load->model("session_model", "Sesion");

        $comunas = $this->Sesion->obtenerComunas();

        $json = array();

        foreach($comunas as $c)
            $json[] = array(
                $c["com_ia_id"],
                $c["com_c_nombre"],
            );

        echo json_encode($json);
    }
    public function getMinMaxUsr() {
        $this->load->model("session_model", "SesionModel");

        $c = $this->SesionModel->getMinMaxUser();


            $json = array(
                'com_c_xmin' => $c["com_c_xmin"],
                'com_c_ymin' => $c["com_c_ymin"],
                'com_c_xmax' => $c["com_c_xmax"],
                'com_c_ymax' => $c["com_c_ymax"],
                'com_c_geozone' => $c["com_c_geozone"]
            );

        echo json_encode($json);
    }

    public function obtenerJsonUsuariosImpersonables() {
        $this->load->helper(array("modulo/direccion/region",
                                  "modulo/usuario/usuario"));
        $this->load->model("usuario_model", "usuario_model");
        $this->load->model("usuario_region_model", 'usuario_region_model');

        $lista = $this->usuario_model->listar();

        $json = array();

        foreach($lista as $usuario){
            $lista_regiones = '';
            $regiones = $this->usuario_region_model->listarPorUsuario($usuario['usu_ia_id']);
            foreach($regiones as $region){
                if($region['id_region'] == 13){
                    $lista_regiones .= 'Región Metropolitana, ';    
                }else{
                    $lista_regiones .= $region['id_region'].'º, ';    
                }
                
            }
            $lista_regiones = trim($lista_regiones,', ');
            $json[] = array(
                $usuario["usu_ia_id"],
                nombreUsuario($usuario["usu_ia_id"]) . " - " . $lista_regiones
            );
        }

        echo json_encode($json);
    }

    public function obtenerJsonMIDAS () {
        $this->load->model("session_model", "Sesion");

        $params = $this->input->get(null, true);

        $usuario = $this->Sesion->obtenerDatosMIDAS($params["rut"]);
        echo json_encode($usuario);
    }

    public function impersonar() {
        $this->load->helper(array(
            "debug",
            "session"
        ));

        $params = $this->uri->uri_to_assoc();

        if (!isAdmin()) {
            show_404();
        }

        $this->load->model("session_model", "SessionModel");
        $cambio = $this->SessionModel->impersonar($params["userID"]);

        if (!$cambio) {
            show_error("Ha ocurrido un error interno", 500);
        }
    }

    public function autentificar() {
        $this->load->library(array(
            "template"
        ));
        $this->load->helper(array(
            "debug",
            "session",
            "url"
        ));

        $params = $this->uri->uri_to_assoc();
        $this->load->model("session_model", "SessionModel");

        $resultado = $this->SessionModel->autentificar($params["rut"]);

        if (!$resultado) {
            show_error("Ha ocurrido un error interno", 500);
        }

        redirect(base_url());
    }
    public function logout(){
         $this->load->helper(array(
            "debug",
            "session",
            "url"
        ));
         $this->session->sess_destroy();
         redirect(base_url());
    }
}