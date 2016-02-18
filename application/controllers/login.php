<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends MY_Controller {
    
    /**
     *
     * @var Usuario_Model 
     */
    public $_usuario_model;
    
    /**
     *
     * @var Session_Model 
     */
    public $_session_model;
    
    /**
     * 
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model','_usuario_model');
        $this->load->model('session_model','_session_model');
    }
    
    /**
     * 
     */
    public function index(){
        if(estaLogeado()){
            redirect(base_url("home"));
        }
        $this->load->view('templates/login', array());
    }
    
    /**
     * 
     */
    public function procesar(){
        $params = $this->input->post(null, true);
        $usuario = $this->_usuario_model->getByUserAndPass($params["username"], $params["password"]);
        if(!is_null($usuario)){
            $this->_session_model->autentificar($usuario->usu_c_rut);
            redirect(base_url("formulario"));
        }
        $this->load->view('templates/login', array("error" => true,
                                                   "mensaje" => "El usuario no es válido, intente nuevamente."));
    }
}

