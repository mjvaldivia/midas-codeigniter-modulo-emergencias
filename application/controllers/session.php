<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * User: claudio
 * Date: 17-08-15
 * Time: 10:58 AM
 */
class Session extends CI_Controller
{
    
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
        $this->load->model("session_model", "Sesion");

        $usuarios = $this->Sesion->obtenerUsuariosImpersonables();

        $json = array();

        foreach($usuarios as $u)
            $json[] = array(
                $u["usu_ia_id"],
                $u["usu_c_cargo"]
            );

        echo json_encode($json);
    }

    public function obtenerJsonMIDAS () {
        $this->load->model("session_model", "Sesion");

        $params = $this->uri->uri_to_assoc();

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